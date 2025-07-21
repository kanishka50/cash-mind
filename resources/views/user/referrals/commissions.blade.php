@extends('layouts.user')

@section('title', 'Commission History')

@section('content')
<div class="container px-4 py-8 mx-auto md:ml-64 content-transition w-auto max-w-full md:max-w-[calc(100%-16rem)]">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Commission History</h2>
        <a href="{{ route('user.referrals.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Dashboard
        </a>
    </div>
    
    <!-- Earnings Summary -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="glass-effect rounded-lg p-5 border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
            <p class="text-gray-400 text-sm">Available Balance</p>
            <h3 class="text-2xl font-bold text-white mt-2">LKR {{ number_format($commission->balance, 2) }}</h3>
            <div class="mt-4">
                <a href="{{ route('user.referrals.payouts.request') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md text-sm hover:bg-opacity-90 transition duration-200 inline-block">Request Payout</a>
            </div>
        </div>
        
        <div class="glass-effect rounded-lg p-5 border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
            <p class="text-gray-400 text-sm">Total Earned</p>
            <h3 class="text-2xl font-bold text-white mt-2">LKR {{ number_format($commission->total_earned, 2) }}</h3>
            <div class="mt-4">
                <a href="{{ route('user.referrals.payouts') }}" class="text-accent-teal hover:text-accent-teal/80 text-sm">View Payout History</a>
            </div>
        </div>
    </div>

    <!-- Commission Earnings List -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                All Earnings
            </h3>
        </div>
        
        @if($earnings->count() > 0)
        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Referred User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rate</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Commission</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($earnings as $earning)
                    <tr class="hover:bg-card transition-colors duration-200">
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $earning->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $earning->referredUser->name ?? 'Unknown User' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            @if($earning->item_type === 'course' && isset($earning->course))
                                {{ $earning->course->title ?? 'Unknown Course' }}
                            @elseif($earning->item_type === 'digital_product' && isset($earning->digitalProduct))
                                {{ $earning->digitalProduct->name ?? 'Unknown Product' }}
                            @else
                                Unknown Item
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $earning->item_type === 'course' ? 'Course' : 'Digital Product' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ number_format($earning->rate_used, 2) }}%</td>
                        <td class="px-4 py-3 text-sm text-gray-300">LKR {{ number_format($earning->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($earning->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-md text-xs">Pending</span>
                            @elseif($earning->status === 'paid')
                            <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Paid</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $earnings->links() }}
        </div>
        @else
        <div class="p-4 glass-effect rounded-lg text-gray-400 border border-gray-800">
            You haven't earned any commissions yet. Start earning by sharing your referral links.
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .glass-effect {
        background: rgba(18, 27, 37, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .bg-darker {
        background-color: rgba(13, 18, 24, 0.8);
    }
</style>
@endpush
@endsection