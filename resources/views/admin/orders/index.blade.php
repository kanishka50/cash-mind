@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-medium text-white">Order Management</h3>
        <div class="flex space-x-3">
            <div class="relative">
                <input type="text" placeholder="Search orders..." 
                      class="bg-darker border border-gray-700 rounded-md py-2 pl-3 pr-10 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent">
                <button class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-accent-teal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
            <select class="bg-darker border border-gray-700 rounded-md py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
                <option value="refunded">Refunded</option>
            </select>
        </div>
    </div>
    
    @if (session('success'))
    <div class="mt-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Order Number
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-mono text-white">#{{ $order->order_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400 text-xs">
                                {{ substr($order->user->name, 0, 2) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-white">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-secondary-400 font-medium">Rs. {{ number_format($order->final_amount, 2) }}</div>
                        @if($order->discount_amount > 0)
                            <div class="text-xs text-green-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                -Rs. {{ number_format($order->discount_amount, 2) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->payment_status === 'completed') bg-green-900 bg-opacity-30 text-green-400 
                            @elseif($order->payment_status === 'pending') bg-yellow-900 bg-opacity-30 text-yellow-400 
                            @elseif($order->payment_status === 'failed') bg-red-900 bg-opacity-30 text-red-400 
                            @else bg-gray-700 bg-opacity-30 text-gray-400 @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-white text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-gray-400 text-xs">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-accent-teal hover:text-accent-light" title="View Order Details">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <p>No orders found.</p>
                            <p class="text-sm text-gray-500 mt-1">Orders will appear here once customers make purchases.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection