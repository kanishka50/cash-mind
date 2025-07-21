@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-medium text-white">Subscription Plans</h3>
        <a href="{{ route('admin.subscriptions.create') }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Plan
            </div>
        </a>
    </div>
    
    @if (session('success'))
    <div class="mt-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    @if (session('error'))
    <div class="mt-4 p-4 bg-red-900 bg-opacity-20 border border-red-800 text-red-300 rounded-md">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Monthly Price
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Yearly Price
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Active Subscribers
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($subscriptionPlans as $plan)
                <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-900 bg-opacity-20 flex items-center justify-center text-purple-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 font-medium text-white">{{ $plan->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-secondary-400 font-medium">Rs. {{ number_format($plan->price_monthly, 2) }}</div>
                        <div class="text-xs text-gray-400">Monthly Billing</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-secondary-400 font-medium">Rs. {{ number_format($plan->price_yearly, 2) }}</div>
                        <div class="text-xs text-gray-400">Yearly Billing</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-900 bg-opacity-30 text-blue-400">
                            {{ $plan->activeSubscribersCount }} {{ Str::plural('user', $plan->activeSubscribersCount) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.subscriptions.edit', $plan) }}" class="text-accent-teal hover:text-accent-light mr-3" title="Edit Plan">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.subscriptions.manage-content', $plan) }}" class="text-purple-400 hover:text-purple-300 mr-3" title="Manage Content">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.subscriptions.destroy', $plan) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400" 
                                    onclick="return confirm('Are you sure you want to delete this plan?')" title="Delete Plan">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>No subscription plans found.</p>
                            <a href="{{ route('admin.subscriptions.create') }}" class="mt-2 text-accent-teal hover:text-accent-light transition duration-200">Create your first subscription plan</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection