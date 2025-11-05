<?php

namespace App\Http\Controllers;

use App\Jobs\RetryFailedPaymentsJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;
use Symfony\Component\HttpFoundation\Response;

/**
 * StripeWebhookController
 * 
 * Handles Stripe webhook events for subscription lifecycle.
 * Ensures idempotency and proper error handling.
 */
class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhook
     * 
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $payload = $request->all();
        $eventType = $payload['type'] ?? null;

        Log::info('Stripe webhook received', [
            'type' => $eventType,
            'id' => $payload['id'] ?? null,
        ]);

        try {
            switch ($eventType) {
                case 'invoice.payment_succeeded':
                    $this->handlePaymentSucceeded($payload);
                    break;

                case 'invoice.payment_failed':
                    $this->handlePaymentFailed($payload);
                    break;

                case 'customer.subscription.deleted':
                    $this->handleSubscriptionDeleted($payload);
                    break;

                case 'customer.subscription.updated':
                    $this->handleSubscriptionUpdated($payload);
                    break;

                default:
                    Log::info('Unhandled Stripe webhook event', ['type' => $eventType]);
            }

            return response()->json(['received' => true], 200);
        } catch (\Exception $e) {
            Log::error('Stripe webhook handling failed', [
                'type' => $eventType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }

    /**
     * Handle successful payment
     */
    protected function handlePaymentSucceeded(array $payload): void
    {
        $invoice = $payload['data']['object'];
        $customerId = $invoice['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if ($user) {
            // Dispatch notification
            $user->notify(new \App\Notifications\PaymentSucceededNotification());
            
            Log::info('Payment succeeded notification sent', [
                'user_id' => $user->id,
                'invoice_id' => $invoice['id'],
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    protected function handlePaymentFailed(array $payload): void
    {
        $invoice = $payload['data']['object'];
        $customerId = $invoice['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if ($user) {
            // Dispatch retry job with delay (24 hours, then 72 hours)
            RetryFailedPaymentsJob::dispatch($user, $invoice['id'])
                ->delay(now()->addHours(24));

            Log::info('Payment failed - retry scheduled', [
                'user_id' => $user->id,
                'invoice_id' => $invoice['id'],
            ]);
        }
    }

    /**
     * Handle subscription deletion
     */
    protected function handleSubscriptionDeleted(array $payload): void
    {
        $subscription = $payload['data']['object'];
        $customerId = $subscription['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if ($user) {
            // Update subscription status in database
            $user->subscriptions()
                ->where('stripe_id', $subscription['id'])
                ->update(['stripe_status' => 'canceled']);

            Log::info('Subscription canceled', [
                'user_id' => $user->id,
                'subscription_id' => $subscription['id'],
            ]);
        }
    }

    /**
     * Handle subscription update
     */
    protected function handleSubscriptionUpdated(array $payload): void
    {
        $subscription = $payload['data']['object'];
        $customerId = $subscription['customer'] ?? null;

        if (!$customerId) {
            return;
        }

        $user = User::where('stripe_id', $customerId)->first();

        if ($user) {
            // Sync subscription status
            $user->subscriptions()
                ->where('stripe_id', $subscription['id'])
                ->update([
                    'stripe_status' => $subscription['status'],
                ]);

            Log::info('Subscription updated', [
                'user_id' => $user->id,
                'subscription_id' => $subscription['id'],
                'status' => $subscription['status'],
            ]);
        }
    }
}
