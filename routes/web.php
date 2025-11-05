<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Subscription routes
    Route::get('/plans', [SubscriptionController::class, 'index'])->name('plans');
    Route::post('/subscription/checkout/{plan}/{provider}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/billing/success/{provider}', [SubscriptionController::class, 'success'])->name('billing.success');
    Route::get('/billing/cancel', [SubscriptionController::class, 'cancel'])->name('billing.cancel');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Webhook routes (excluded from CSRF protection)
Route::post('/webhook/stripe', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])->name('webhook.stripe');
Route::post('/webhook/mollie', [\App\Http\Controllers\MollieWebhookController::class, 'handle'])->name('webhook.mollie');

require __DIR__.'/auth.php';
