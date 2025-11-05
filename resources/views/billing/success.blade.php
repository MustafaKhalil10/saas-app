<x-layout title="Payment Successful">
    <div class="max-w-2xl mx-auto space-y-6">
        <x-card>
            <div class="text-center space-y-4">
                <div class="text-6xl">✅</div>
                <h2 class="text-3xl font-bold text-dark">Payment Successful!</h2>
                <p class="text-graydark text-lg">
                    Thank you for your subscription. Your payment has been processed successfully.
                </p>
                
                <div class="pt-4 space-y-2">
                    <p class="text-dark">
                        <strong>Provider:</strong> {{ ucfirst($provider) }}
                    </p>
                    <p class="text-graydark">
                        Your subscription is now active. You can access all features immediately.
                    </p>
                </div>
                
                <div class="pt-6 space-x-4">
                    <a href="{{ route('dashboard') }}" class="inline-block">
                        <x-button>Go to Dashboard</x-button>
                    </a>
                    <a href="{{ route('plans') }}" class="inline-block">
                        <x-button color="graylight">View Plans</x-button>
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</x-layout>

