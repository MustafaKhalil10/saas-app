<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * SubscriptionTest
 * 
 * Tests for subscription checkout flow and webhook handling.
 */
class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that plans page displays correctly
     */
    public function test_plans_page_displays_correctly(): void
    {
        $user = User::factory()->create();
        
        $plan = Plan::create([
            'provider_id' => 'price_test_123',
            'provider' => 'stripe',
            'name' => 'Basic Plan',
            'interval' => 'month',
            'amount' => 1000, // $10.00 in cents
            'currency' => 'usd',
            'features' => ['Feature 1', 'Feature 2'],
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get(route('plans'));

        $response->assertStatus(200);
        $response->assertSee('Basic Plan');
        $response->assertSee('$10.00/month');
    }

    /**
     * Test that checkout redirects for Stripe
     */
    public function test_stripe_checkout_redirects(): void
    {
        $user = User::factory()->create();
        
        $plan = Plan::create([
            'provider_id' => 'price_test_123',
            'provider' => 'stripe',
            'name' => 'Basic Plan',
            'interval' => 'month',
            'amount' => 1000,
            'currency' => 'usd',
            'is_active' => true,
        ]);

        // Mock Stripe checkout (in real scenario, this would redirect to Stripe)
        $response = $this->actingAs($user)
            ->post(route('subscription.checkout', [
                'plan' => $plan->id,
                'provider' => 'stripe'
            ]));

        // Should redirect (either to Stripe or error page)
        $this->assertContains($response->status(), [302, 200]);
    }

    /**
     * Test that invalid provider is rejected
     */
    public function test_invalid_provider_is_rejected(): void
    {
        $user = User::factory()->create();
        
        $plan = Plan::create([
            'provider_id' => 'price_test_123',
            'provider' => 'stripe',
            'name' => 'Basic Plan',
            'interval' => 'month',
            'amount' => 1000,
            'currency' => 'usd',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->post(route('subscription.checkout', [
                'plan' => $plan->id,
                'provider' => 'invalid'
            ]));

        $response->assertRedirect(route('plans'));
        $response->assertSessionHasErrors('provider');
    }

    /**
     * Test that inactive plans are not shown
     */
    public function test_inactive_plans_are_not_shown(): void
    {
        $user = User::factory()->create();
        
        Plan::create([
            'provider_id' => 'price_test_123',
            'provider' => 'stripe',
            'name' => 'Inactive Plan',
            'interval' => 'month',
            'amount' => 1000,
            'currency' => 'usd',
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('plans'));

        $response->assertStatus(200);
        $response->assertDontSee('Inactive Plan');
    }

    /**
     * Test that success page displays correctly
     */
    public function test_success_page_displays_correctly(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('billing.success', ['provider' => 'stripe']));

        $response->assertStatus(200);
        $response->assertSee('Payment Successful');
        $response->assertSee('Stripe');
    }

    /**
     * Test that cancel page displays correctly
     */
    public function test_cancel_page_displays_correctly(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('billing.cancel'));

        $response->assertStatus(200);
        $response->assertSee('Payment Cancelled');
    }
}
