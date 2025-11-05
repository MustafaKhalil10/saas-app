<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'provider_id' => 'price_basic_monthly', // Replace with actual Stripe/Mollie price ID
                'provider' => 'stripe',
                'name' => 'Basic',
                'interval' => 'month',
                'amount' => 1000, // $10.00 in cents
                'currency' => 'usd',
                'features' => ['1 Project', 'Basic Support', 'Email Support'],
                'is_active' => true,
            ],
            [
                'provider_id' => 'price_pro_monthly',
                'provider' => 'stripe',
                'name' => 'Pro',
                'interval' => 'month',
                'amount' => 2500, // $25.00 in cents
                'currency' => 'usd',
                'features' => ['5 Projects', 'Priority Support', 'Email + Phone Support'],
                'is_active' => true,
            ],
            [
                'provider_id' => 'price_enterprise_monthly',
                'provider' => 'stripe',
                'name' => 'Enterprise',
                'interval' => 'month',
                'amount' => 5000, // $50.00 in cents
                'currency' => 'usd',
                'features' => ['Unlimited Projects', 'Dedicated Manager', '24/7 Support'],
                'is_active' => true,
            ],
            // Mollie Plans
            [
                'provider_id' => 'mollie_basic_monthly',
                'provider' => 'mollie',
                'name' => 'Basic',
                'interval' => 'month',
                'amount' => 1000,
                'currency' => 'eur',
                'features' => ['1 Project', 'Basic Support', 'Email Support'],
                'is_active' => true,
            ],
            [
                'provider_id' => 'mollie_pro_monthly',
                'provider' => 'mollie',
                'name' => 'Pro',
                'interval' => 'month',
                'amount' => 2500,
                'currency' => 'eur',
                'features' => ['5 Projects', 'Priority Support', 'Email + Phone Support'],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(
                ['provider_id' => $plan['provider_id'], 'provider' => $plan['provider']],
                $plan
            );
        }
    }
}

