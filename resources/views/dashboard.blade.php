<x-layout title="Dashboard">
    <div class="flex flex-col space-y-6">
        <h2 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }} 👋</h2>
        <p class="text-graydark">Here's your quick overview of your account and subscription.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card>
                <h3 class="text-xl font-semibold mb-2">Your Role</h3>
                <p class="text-graydark">{{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}</p>
            </x-card>

            <x-card>
                <h3 class="text-xl font-semibold mb-2">Current Plan</h3>
                @php
                    $subscription = Auth::user()->subscription('default');
                @endphp
                @if($subscription && $subscription->valid())
                    <p class="text-graydark">{{ $subscription->name ?? 'Active Subscription' }}</p>
                @else
                    <p class="text-graydark">No Active Plan</p>
                @endif
            </x-card>

            <x-card>
                <h3 class="text-xl font-semibold mb-2">Next Billing</h3>
                @php
                    $subscription = Auth::user()->subscription('default');
                @endphp
                @if($subscription && $subscription->ends_at)
                    <p class="text-graydark">{{ $subscription->ends_at->format('d M Y') }}</p>
                @else
                    <p class="text-graydark">N/A</p>
                @endif
            </x-card>
        </div>
    </div>
</x-layout>
