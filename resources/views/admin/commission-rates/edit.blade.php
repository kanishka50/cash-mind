<!-- resources/views/admin/commission-rates/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Edit Commission Rate</h2>
        <a href="{{ route('admin.commission-rates.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Commission Rates
        </a>
    </div>

    @if(session('error'))
    <div class="mt-4 p-4 bg-red-500 bg-opacity-20 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <div class="mt-8 bg-card rounded-lg p-6">
        <div class="mb-6">
            <h3 class="text-lg font-medium text-white mb-2">Item Details</h3>
            <p class="text-gray-400">Item Type: <span class="text-accent-teal">{{ ucfirst($commissionRate->item_type) }}</span></p>
            <p class="text-gray-400">Item Name: <span class="text-accent-teal">{{ $itemName }}</span></p>
        </div>
        
        <form action="{{ route('admin.commission-rates.update', $commissionRate) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="rate" class="block text-sm font-medium text-gray-400 mb-1">Commission Rate (%)</label>
                <input type="number" id="rate" name="rate" min="0" max="100" step="0.01" value="{{ old('rate', $commissionRate->rate) }}" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                @error('rate')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $commissionRate->is_active) ? 'checked' : '' }} class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal">
                    <span class="ml-2 text-sm text-gray-300">Active</span>
                </label>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Update Commission Rate
                </button>
            </div>
        </form>
    </div>
</div>
@endsection