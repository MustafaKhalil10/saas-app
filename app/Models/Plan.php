<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Plan Model
 * 
 * Represents a subscription plan available in the system.
 * Supports both Stripe and Mollie payment providers.
 */
class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'provider',
        'name',
        'interval',
        'amount',
        'currency',
        'features',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get formatted price for display
     */
    public function getFormattedPriceAttribute(): string
    {
        $amount = $this->amount / 100; // Convert cents to dollars
        $currencySymbol = $this->currency === 'usd' ? '$' : '€';
        
        return $currencySymbol . number_format($amount, 2) . '/' . $this->interval;
    }

    /**
     * Scope to get active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by provider
     */
    public function scopeByProvider($query, string $provider)
    {
        return $query->where('provider', $provider);
    }
}
