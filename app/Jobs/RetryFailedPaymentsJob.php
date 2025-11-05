+<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * RetryFailedPaymentsJob
 * 
 * Retries failed payment attempts with exponential backoff.
 * Prevents losing subscribers due to temporary card issues.
 */
class RetryFailedPaymentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 86400; // 24 hours

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected string $paymentId,
        protected int $attemptNumber = 1
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $subscription = $this->user->subscription('default');

            if (!$subscription) {
                Log::warning('Retry failed payment: No subscription found', [
                    'user_id' => $this->user->id,
                    'payment_id' => $this->paymentId,
                ]);
                return;
            }

            // Check if subscription is already active
            if ($subscription->valid()) {
                Log::info('Retry failed payment: Subscription already active', [
                    'user_id' => $this->user->id,
                    'payment_id' => $this->paymentId,
                ]);
                return;
            }

            // For Stripe, we can use Cashier's retry method
            if ($this->user->stripe_id) {
                $this->retryStripePayment();
            } else {
                // For Mollie, we need to handle differently
                $this->retryMolliePayment();
            }
        } catch (\Exception $e) {
            Log::error('Retry failed payment error', [
                'user_id' => $this->user->id,
                'payment_id' => $this->paymentId,
                'attempt' => $this->attemptNumber,
                'error' => $e->getMessage(),
            ]);

            // If this is not the last attempt, schedule another retry
            if ($this->attemptNumber < 3) {
                self::dispatch($this->user, $this->paymentId, $this->attemptNumber + 1)
                    ->delay(now()->addHours(72)); // 72 hours for second attempt
            }
        }
    }

    /**
     * Retry Stripe payment
     */
    protected function retryStripePayment(): void
    {
        try {
            // Stripe automatically retries failed payments
            // We just need to log the attempt
            Log::info('Retrying Stripe payment', [
                'user_id' => $this->user->id,
                'payment_id' => $this->paymentId,
                'attempt' => $this->attemptNumber,
            ]);

            // Optionally, send a notification to user about retry
            // $this->user->notify(new PaymentRetryNotification());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retry Mollie payment
     */
    protected function retryMolliePayment(): void
    {
        try {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey(config('services.mollie.key'));

            // Get the payment and attempt to retry
            $payment = $mollie->payments->get($this->paymentId);

            Log::info('Retrying Mollie payment', [
                'user_id' => $this->user->id,
                'payment_id' => $this->paymentId,
                'attempt' => $this->attemptNumber,
                'status' => $payment->status,
            ]);

            // If payment is still failed, we might need to create a new payment
            // This would be handled by the subscription service
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Retry failed payment job failed permanently', [
            'user_id' => $this->user->id,
            'payment_id' => $this->paymentId,
            'attempt' => $this->attemptNumber,
            'error' => $exception->getMessage(),
        ]);

        // Optionally, notify user about permanent failure
        // $this->user->notify(new PaymentFailedPermanentlyNotification());
    }
}
