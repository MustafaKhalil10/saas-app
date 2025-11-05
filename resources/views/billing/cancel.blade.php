<x-layout title="Payment Cancelled">
    <div class="max-w-2xl mx-auto space-y-6">
        <x-card>
            <div class="text-center space-y-4">
                <div class="text-6xl">⚠️</div>
                <h2 class="text-3xl font-bold text-dark">Payment Cancelled</h2>
                <p class="text-graydark text-lg">
                    Your payment was cancelled. No charges have been made to your account.
                </p>
                
                <div class="pt-4">
                    <p class="text-graydark">
                        If you encountered any issues during checkout, please try again or contact our support team.
                    </p>
                </div>
                
                <div class="pt-6 space-x-4">
                    <a href="{{ route('plans') }}" class="inline-block">
                        <x-button>Try Again</x-button>
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-block">
                        <x-button color="graylight">Go to Dashboard</x-button>
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</x-layout>

