<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Subscription as MollieSubscription;
use Stripe\Exception\InvalidRequestException;

/**
 * SubscriptionService
 * 
 * Handles subscription operations for both Stripe and Mollie providers.
 * Follows Single Responsibility Principle - manages subscription lifecycle.
 */
class SubscriptionService
{
    /**
     * Create a Stripe checkout session
     */
    public function createStripeCheckout(User $user, Plan $plan): string
    {
        // Validate Stripe API keys
        $stripeKey = config('services.stripe.key');
        $stripeSecret = config('services.stripe.secret');
        
        if (empty($stripeKey) || empty($stripeSecret)) {
            Log::error('Stripe API keys not configured', [
                'has_key' => !empty($stripeKey),
                'has_secret' => !empty($stripeSecret),
            ]);
            throw new \Exception('Stripe payment gateway is not configured. Please add STRIPE_KEY and STRIPE_SECRET to .env file.');
        }

        try {
            // Validate provider_id exists
            if (empty($plan->provider_id)) {
                throw new \Exception('Plan provider ID is missing. Please configure the plan correctly.');
            }

            $checkout = $user->newSubscription('default', $plan->provider_id)
                ->checkout([
                    'success_url' => route('billing.success', ['provider' => 'stripe']),
                    'cancel_url' => route('plans'),
                ]);

            // Get checkout URL - Laravel Cashier returns CheckoutSession object
            $checkoutUrl = $checkout->url ?? null;
            
            if (empty($checkoutUrl)) {
                Log::error('Checkout URL is empty', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'provider_id' => $plan->provider_id,
                    'checkout_object' => get_class($checkout),
                ]);
                throw new \Exception('Failed to create checkout session. Please check your Stripe configuration and Price ID.');
            }

            return $checkoutUrl;
        } catch (InvalidRequestException $e) {
            Log::error('Stripe checkout creation failed - Invalid Request', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'provider_id' => $plan->provider_id,
                'error' => $e->getMessage(),
            ]);

            if (str_contains($e->getMessage(), 'No such price')) {
                throw new \Exception('The plan price ID does not exist in Stripe. Please create the price in Stripe Dashboard first.');
            }

            throw new \Exception('Stripe error: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Stripe checkout creation failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'provider_id' => $plan->provider_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('Failed to create checkout session: ' . $e->getMessage());
        }
    }

    /**
     * Create a Mollie checkout session
     */
    public function createMollieCheckout(User $user, Plan $plan): string
    {
        // Validate Mollie API key
        $mollieKey = config('services.mollie.key');
        if (empty($mollieKey)) {
            Log::error('Mollie API key not configured');
            throw new \Exception('Mollie payment gateway is not configured. Please contact support.');
        }

        try {
            $mollie = new MollieApiClient();
            $mollie->setApiKey($mollieKey);

            // Create customer in Mollie if not exists
            $mollieCustomerId = $user->mollie_customer_id;
            if (!$mollieCustomerId) {
                $mollieCustomer = $mollie->customers->create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $mollieCustomerId = $mollieCustomer->id;
                $user->update(['mollie_customer_id' => $mollieCustomerId]);
            }

            // Create subscription in Mollie
            $subscription = $mollie->subscriptions->createFor($mollie->customers->get($mollieCustomerId), [
                'amount' => [
                    'currency' => strtoupper($plan->currency),
                    'value' => number_format($plan->amount / 100, 2, '.', ''),
                ],
                'interval' => $plan->interval === 'month' ? '1 month' : '1 year',
                'description' => $plan->name . ' Subscription',
                'webhookUrl' => route('webhook.mollie'),
            ]);

            // Store subscription reference
            $user->subscriptions()->create([
                'type' => 'default',
                'stripe_id' => $subscription->id,
                'stripe_status' => 'active',
                'stripe_price' => $plan->provider_id,
                'quantity' => 1,
            ]);

            // Return payment URL (for first payment)
            return $subscription->links->paymentUrl ?? route('plans');
        } catch (\Exception $e) {
            Log::error('Mollie checkout creation failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to create checkout session. Please try again.');
        }
    }

    /**
     * Cancel user's subscription
     */
    public function cancelSubscription(User $user, string $provider = 'stripe'): bool
    {
        try {
            if ($provider === 'stripe') {
                $user->subscription('default')->cancel();
            } else {
                // Handle Mollie cancellation
                $mollieKey = config('services.mollie.key');
                if (empty($mollieKey)) {
                    Log::error('Mollie API key not configured for cancellation');
                    return false;
                }

                $mollie = new MollieApiClient();
                $mollie->setApiKey($mollieKey);
                
                if ($user->mollie_customer_id) {
                    $customer = $mollie->customers->get($user->mollie_customer_id);
                    $subscriptions = $customer->subscriptions();
                    
                    foreach ($subscriptions as $subscription) {
                        $subscription->cancel();
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Subscription cancellation failed', [
                'user_id' => $user->id,
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}

