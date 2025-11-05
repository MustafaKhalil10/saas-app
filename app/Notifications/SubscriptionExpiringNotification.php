<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

/**
 * SubscriptionExpiringNotification
 * 
 * Sends email and WhatsApp notifications when subscription is expiring soon.
 * Helps prevent accidental subscription cancellations.
 */
class SubscriptionExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Days until expiration
     */
    protected int $daysUntilExpiration;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $daysUntilExpiration = 7)
    {
        $this->daysUntilExpiration = $daysUntilExpiration;
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
        $days = $this->daysUntilExpiration;
        $message = $days === 1 
            ? 'Your subscription expires tomorrow.'
            : "Your subscription expires in {$days} days.";

        return (new MailMessage)
            ->subject('Subscription Expiring Soon')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($message)
            ->line('To ensure uninterrupted service, please renew your subscription.')
            ->action('Renew Subscription', route('plans'))
            ->line('Thank you for being a valued customer!');
    }

    /**
     * Get the Twilio / WhatsApp representation of the notification.
     */
    public function toTwilio(object $notifiable): TwilioSmsMessage
    {
        $days = $this->daysUntilExpiration;
        $message = $days === 1 
            ? "Hello {$notifiable->name}! ⚠️ Your subscription expires tomorrow. Renew now: " . route('plans')
            : "Hello {$notifiable->name}! ⚠️ Your subscription expires in {$days} days. Renew: " . route('plans');

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
            'type' => 'subscription_expiring',
            'days_until_expiration' => $this->daysUntilExpiration,
            'message' => "Your subscription expires in {$this->daysUntilExpiration} days.",
        ];
    }
}
