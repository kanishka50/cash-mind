{{-- resources/views/admin/payment-verifications/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Payment Verifications')

@section('content')
<div class="bg-card rounded-lg shadow-md border border-gray-800">
    <div class="p-6 border-b border-gray-800">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-100">Pending Payment Verifications</h1>
            
            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.payment-verifications.index') }}" class="flex gap-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                    class="px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="From Date">
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                    class="px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="To Date">
                <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['date_from', 'date_to']))
                    <a href="{{ route('admin.payment-verifications.index') }}" class="px-4 py-2 bg-gray-700 text-gray-200 rounded-md hover:bg-gray-600 transition-colors">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($pendingPayments->isEmpty())
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-400">No pending payment verifications.</p>
            </div>
        @else
            <table class="min-w-full">
                <thead class="bg-darker">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Uploaded</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($pendingPayments as $payment)
                    <tr class="hover:bg-darker/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $payment->type === 'order' ? 'bg-blue-900/20 text-blue-400' : 'bg-purple-900/20 text-purple-400' }}">
                                {{ ucfirst($payment->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            @if($payment->type === 'order')
                                {{ $payment->order_number }}
                            @else
                                {{ $payment->subscriptionPlan->name }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $payment->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">
                            Rs. {{ number_format($payment->type === 'order' ? $payment->final_amount : $payment->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            {{ $payment->payment_receipt_uploaded_at->format('M d, Y h:i A') }}
                            <div class="text-xs text-gray-500">{{ $payment->payment_receipt_uploaded_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($payment->type === 'order')
                                <a href="{{ route('admin.payment-verifications.show-order', $payment) }}" 
                                   class="text-primary-400 hover:text-primary-300 font-medium">
                                    Review
                                </a>
                            @else
                                <a href="{{ route('admin.payment-verifications.show-subscription', $payment) }}" 
                                   class="text-primary-400 hover:text-primary-300 font-medium">
                                    Review
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
        <h3 class="text-lg font-semibold text-gray-200 mb-2">Pending Orders</h3>
        <p class="text-3xl font-bold text-blue-400">{{ $pendingPayments->where('type', 'order')->count() }}</p>
    </div>
    <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
        <h3 class="text-lg font-semibold text-gray-200 mb-2">Pending Subscriptions</h3>
        <p class="text-3xl font-bold text-purple-400">{{ $pendingPayments->where('type', 'subscription')->count() }}</p>
    </div>
    <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
        <h3 class="text-lg font-semibold text-gray-200 mb-2">Total Pending Amount</h3>
        <p class="text-2xl font-bold text-green-400">
            Rs. {{ number_format($pendingPayments->sum(function($p) { 
                return $p->type === 'order' ? $p->final_amount : $p->price; 
            }), 2) }}
        </p>
    </div>
</div>
@endsection