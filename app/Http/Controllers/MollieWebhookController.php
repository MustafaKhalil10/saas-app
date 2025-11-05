<?php

namespace App\Http\Controllers;

use App\Jobs\RetryFailedPaymentsJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Api\MollieApiClient;
use Symfony\Component\HttpFoundation\Response;

/**
 * MollieWebhookController
 * 
 * Handles Mollie webhook events for subscription lifecycle.
 * Ensures idempotency and proper error handling.
 */
class MollieWebhookController extends Controller
{
    /**
     * Handle incoming Mollie webhook
     * 
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $paymentId = $request->input('id');

        if (!$paymentId) {
            return response()->json(['error' => 'Missing payment ID'], 400);
        }

        try {
            $mollieKey = config('services.mollie.key');
            if (empty($mollieKey)) {
                Log::error('Mollie API key not configured for webhook');
                return response()->json(['error' => 'Mollie API key not configured'], 500);
            }

            $mollie = new MollieApiClient();
            $mollie->setApiKey($mollieKey);

            $payment = $mollie->payments->get($paymentId);
            $customerId = $payment->customerId ?? null;

            if (!$customerId) {
                return response()->json(['error' => 'Missing customer ID'], 400);
            }

            $user = User::where('mollie_customer_id', $customerId)->first();

            if (!$user) {
                Log::warning('Mollie webhook: User not found', [
                    'customer_id' => $customerId,
                    'payment_id' => $paymentId,
                ]);
                return response()->json(['error' => 'User not found'], 404);
            }

            Log::info('Mollie webhook received', [
                'payment_id' => $paymentId,
                'status' => $payment->status,
                'user_id' => $user->id,
            ]);

            switch ($payment->status) {
                case 'paid':
                    $this->handlePaymentSucceeded($user, $payment);
                    break;

                case 'failed':
                case 'expired':
                    $this->handlePaymentFailed($user, $payment);
                    break;

                case 'canceled':
                    $this->handlePaymentCanceled($user, $payment);
                    break;

                default:
                    Log::info('Unhandled Mollie payment status', [
                        'status' => $payment->status,
                        'payment_id' => $paymentId,
                    ]);
            }

            return response()->json(['received' => true], 200);
        } catch (\Exception $e) {
            Log::error('Mollie webhook handling failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }

    /**
     * Handle successful payment
     */
    protected function handlePaymentSucceeded(User $user, $payment): void
    {
        // Update subscription status
        $user->subscriptions()
            ->where('stripe_id', $payment->subscriptionId ?? $payment->id)
            ->update(['stripe_status' => 'active']);

        // Dispatch notification
        $user->notify(new \App\Notifications\PaymentSucceededNotification());

        Log::info('Mollie payment succeeded', [
            'user_id' => $user->id,
            'payment_id' => $payment->id,
        ]);
    }

    /**
     * Handle failed payment
     */
    protected function handlePaymentFailed(User $user, $payment): void
    {
        // Dispatch retry job with delay
        RetryFailedPaymentsJob::dispatch($user, $payment->id)
            ->delay(now()->addHours(24));

        Log::info('Mollie payment failed - retry scheduled', [
            'user_id' => $user->id,
            'payment_id' => $payment->id,
        ]);
    }

    /**
     * Handle canceled payment
     */
    protected function handlePaymentCanceled(User $user, $payment): void
    {
        // Update subscription status
        $user->subscriptions()
            ->where('stripe_id', $payment->subscriptionId ?? $payment->id)
            ->update(['stripe_status' => 'canceled']);

        Log::info('Mollie payment canceled', [
            'user_id' => $user->id,
            'payment_id' => $payment->id,
        ]);
    }
}
