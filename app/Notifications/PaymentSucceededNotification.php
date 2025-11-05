<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

/**
 * PaymentSucceededNotification
 * 
 * Sends email and WhatsApp notifications when payment succeeds.
 * Supports multiple channels for better user engagement.
 */
class PaymentSucceededNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['mail'];

        // Add WhatsApp if phone number is available
        if ($notifiable->phone) {
            $channels[] = TwilioChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Successful - Subscription Active')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your payment has been successfully processed.')
            ->line('Your subscription is now active and you have full access to all features.')
            ->action('View Dashboard', route('dashboard'))
            ->line('Thank you for using our service!');
    }

    /**
     * Get the Twilio / WhatsApp representation of the notification.
     */
    public function toTwilio(object $notifiable): TwilioSmsMessage
    {
        $message = "Hello {$notifiable->name}! ✅ Your payment was successful. Your subscription is now active. Visit: " . route('dashboard');

        return (new TwilioSmsMessage())
            ->content($message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_succeeded',
            'message' => 'Your payment has been successfully processed.',
        ];
    }
}
