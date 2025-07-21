<!-- resources/views/admin/payouts/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h2 class="text-xl font-semibold text-white">Affiliate Payouts</h2>
    
    @if(session('success'))
    <div class="mt-4 p-4 bg-green-500 bg-opacity-20 text-green-400 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mt-4 p-4 bg-red-500 bg-opacity-20 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <!-- Status Filter Tabs -->
    <div class="mt-6 border-b border-gray-800">
        <div class="flex space-x-8">
            <a href="{{ route('admin.payouts.index', ['status' => 'pending']) }}" class="pb-4 px-1 {{ $status === 'pending' ? 'border-b-2 border-accent-teal text-accent-teal' : 'text-gray-400 hover:text-white' }}">
                Pending <span class="ml-1 px-2 py-1 text-xs rounded-full bg-gray-700">{{ $pendingCount }}</span>
            </a>
            <a href="{{ route('admin.payouts.index', ['status' => 'paid']) }}" class="pb-4 px-1 {{ $status === 'paid' ? 'border-b-2 border-accent-teal text-accent-teal' : 'text-gray-400 hover:text-white' }}">
                Paid <span class="ml-1 px-2 py-1 text-xs rounded-full bg-gray-700">{{ $paidCount }}</span>
            </a>
            <a href="{{ route('admin.payouts.index', ['status' => 'rejected']) }}" class="pb-4 px-1 {{ $status === 'rejected' ? 'border-b-2 border-accent-teal text-accent-teal' : 'text-gray-400 hover:text-white' }}">
                Rejected <span class="ml-1 px-2 py-1 text-xs rounded-full bg-gray-700">{{ $rejectedCount }}</span>
            </a>
            <a href="{{ route('admin.payouts.index', ['status' => 'all']) }}" class="pb-4 px-1 {{ $status === 'all' ? 'border-b-2 border-accent-teal text-accent-teal' : 'text-gray-400 hover:text-white' }}">
                All
            </a>
        </div>
    </div>

    <!-- Payout Requests List -->
    <div class="mt-6">
        @if($payouts->count() > 0)
        <div class="bg-card rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Payment Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($payouts as $payout)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $payout->user->name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            LKR {{ number_format($payout->amount, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $payout->payment_method }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($payout->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-md text-xs">Pending</span>
                            @elseif($payout->status === 'paid')
                            <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Paid</span>
                            @elseif($payout->status === 'rejected')
                            <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $payout->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            <a href="{{ route('admin.payouts.show', $payout) }}" class="text-accent-teal hover:text-accent-teal-light">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $payouts->links() }}
        </div>
        @else
        <div class="p-4 bg-card rounded-lg text-gray-400">
            No payout requests found.
        </div>
        @endif
    </div>
</div>
@endsection