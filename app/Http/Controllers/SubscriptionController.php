<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * SubscriptionController
 * 
 * Handles subscription checkout flow for both Stripe and Mollie.
 * Follows Clean Architecture - delegates business logic to services.
 */
class SubscriptionController extends Controller
{
    /**
     * @var SubscriptionService
     */
    protected SubscriptionService $subscriptionService;

    /**
     * Constructor - Dependency Injection
     * 
     * Note: Authentication middleware is applied via routes (routes/web.php)
     * In Laravel 12, middleware() is not available in Controller constructor.
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display available subscription plans
     */
    public function index()
    {
        $plans = Plan::active()->get();
        
        return view('plans', [
            'plans' => $plans,
        ]);
    }

    /**
     * Initiate checkout session for a plan
     * 
     * @param Request $request
     * @param int $planId
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request, int $planId, string $provider)
    {
        // Validate provider
        if (!in_array($provider, ['stripe', 'mollie'])) {
            return redirect()->route('plans')
                ->withErrors(['provider' => 'Invalid payment provider.']);
        }

        // Validate plan exists and is active
        $plan = Plan::where('id', $planId)
            ->where('provider', $provider)
            ->active()
            ->firstOrFail();

        try {
            $user = Auth::user();

            // Create checkout session based on provider
            if ($provider === 'stripe') {
                $checkoutUrl = $this->subscriptionService->createStripeCheckout($user, $plan);
            } else {
                $checkoutUrl = $this->subscriptionService->createMollieCheckout($user, $plan);
            }

            return redirect($checkoutUrl);
        } catch (\Exception $e) {
            return redirect()->route('plans')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle successful payment return
     */
    public function success(Request $request, string $provider)
    {
        $user = Auth::user();
        
        return view('billing.success', [
            'provider' => $provider,
            'user' => $user,
        ]);
    }

    /**
     * Handle cancelled payment return
     */
    public function cancel()
    {
        return view('billing.cancel');
    }
}
