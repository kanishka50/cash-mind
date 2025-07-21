@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Coupons</h1>
            <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-90 transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Coupon
        </a>
    </div>
    
    <!-- Table Container -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Code
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Value
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Valid Until
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Uses
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($coupons as $coupon)
                    <tr class="hover:bg-gray-900 hover:bg-opacity-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-white">{{ $coupon->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-300">{{ ucfirst($coupon->type) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-secondary-400 font-medium">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->value }}%
                                @else
                                    Rs. {{ number_format($coupon->value, 2) }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-300">
                                {{ $coupon->valid_until ? $coupon->valid_until->format('M d, Y') : 'No expiration' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-300">
                                {{ $coupon->times_used }}
                                @if($coupon->max_uses)
                                    <span class="text-gray-400">/ {{ $coupon->max_uses }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coupon->is_active)
                                <span class="px-2 py-1 text-xs bg-accent-teal bg-opacity-10 text-accent-teal rounded-full">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-500 bg-opacity-10 text-red-400 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-accent-teal hover:text-white mr-4 transition-colors duration-200">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-200" onclick="return confirm('Are you sure you want to delete this coupon?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-400">
                            No coupons found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection