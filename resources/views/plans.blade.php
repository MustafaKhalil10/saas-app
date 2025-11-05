<x-layout title="Plans">
    <div class="space-y-8">
        <h2 class="text-3xl font-bold text-dark">Choose Your Plan</h2>
        
        {{-- Display Errors --}}
        @if($errors->any())
            <x-alert type="error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error">
                <p>{{ session('error') }}</p>
            </x-alert>
        @endif
        
        @if($plans->isEmpty())
            <x-card>
                <p class="text-graydark">No plans available at the moment. Please check back later.</p>
            </x-card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <x-card>
                        <h3 class="text-2xl font-semibold mb-4">{{ $plan->name }}</h3>
                        <p class="text-dark text-xl mb-4">{{ $plan->formatted_price }}</p>
                        
                        @if($plan->features)
                            <ul class="space-y-1 text-graydark mb-4">
                                @foreach($plan->features as $feature)
                                    <li>• {{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <div class="space-y-2">
                            @php
                                // التحقق الصحيح من Stripe keys (استخدام config بدلاً من env)
                                $stripeKey = config('services.stripe.key');
                                $stripeSecret = config('services.stripe.secret');
                                $stripeConfigured = !empty($stripeKey) && !empty($stripeSecret);
                                $mollieConfigured = !empty(config('services.mollie.key'));
                            @endphp

                            @if(($plan->provider === 'stripe' || $plan->provider === 'both') && $stripeConfigured)
                                <form action="{{ route('subscription.checkout', ['plan' => $plan->id, 'provider' => 'stripe']) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    <x-button type="submit" class="w-full justify-center">
                                        Subscribe with Stripe
                                    </x-button>
                                </form>
                            @endif

                            @if(($plan->provider === 'stripe' || $plan->provider === 'both') && !$stripeConfigured)
                                <div class="relative group">
                                    <x-button disabled class="w-full justify-center opacity-50 cursor-not-allowed" title="Stripe API keys are not configured. Please add STRIPE_KEY and STRIPE_SECRET to .env file.">
                                        Stripe Not Available
                                    </x-button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-dark text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10">
                                        Stripe API keys not configured
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-dark"></div>
                                    </div>
                                </div>
                            @endif
                            
                            @if(($plan->provider === 'mollie' || $plan->provider === 'both') && $mollieConfigured)
                                <form action="{{ route('subscription.checkout', ['plan' => $plan->id, 'provider' => 'mollie']) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    <x-button type="submit" color="graylight" class="w-full justify-center">
                                        Subscribe with Mollie
                                    </x-button>
                                </form>
                            @endif

                            @if(($plan->provider === 'mollie' || $plan->provider === 'both') && !$mollieConfigured)
                                <div class="relative group">
                                    <x-button disabled color="graylight" class="w-full justify-center opacity-50 cursor-not-allowed" title="Mollie API key is not configured. Please add MOLLIE_KEY to .env file.">
                                        Mollie Not Available
                                    </x-button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-dark text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10">
                                        Mollie API key not configured
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-dark"></div>
                                    </div>
                                </div>
                            @endif

                            @if(!$stripeConfigured && !$mollieConfigured && $plan->provider === 'both')
                                <x-alert type="warning" class="mt-2">
                                    <p class="text-sm text-center">Payment gateways are not configured. Please add API keys to <code class="bg-gray-100 px-1 rounded">.env</code> file.</p>
                                </x-alert>
                            @endif
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
