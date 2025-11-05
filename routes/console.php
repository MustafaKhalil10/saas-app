<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule subscription expiring reminders
Schedule::call(function () {
    \App\Models\User::whereHas('subscriptions', function ($query) {
        $query->where('stripe_status', 'active')
            ->where('ends_at', '<=', now()->addDays(7))
            ->where('ends_at', '>', now());
    })->chunk(100, function ($users) {
        foreach ($users as $user) {
            $subscription = $user->subscription('default');
            if ($subscription && $subscription->ends_at) {
                $daysUntilExpiration = now()->diffInDays($subscription->ends_at);
                
                if ($daysUntilExpiration <= 7 && $daysUntilExpiration > 0) {
                    $user->notify(new \App\Notifications\SubscriptionExpiringNotification($daysUntilExpiration));
                }
            }
        }
    });
})->daily()->at('09:00')->name('subscription-expiring-reminders');
