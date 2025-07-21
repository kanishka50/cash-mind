<!-- resources/views/admin/commission-rates/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Commission Rates</h2>
        <a href="{{ route('admin.commission-rates.create') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200">
            Add New Rate
        </a>
    </div>

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

    <!-- Course Commission Rates -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-white">Course Commission Rates</h3>
        
        @if($courseRates->count() > 0)
        <div class="mt-4 bg-card rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rate (%)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($courseRates as $rate)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $rate->course ? $rate->course->title : 'Unknown Course' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $rate->rate }}%</td>
                        <td class="px-4 py-3 text-sm">
                            @if($rate->is_active)
                            <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Active</span>
                            @else
                            <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.commission-rates.edit', $rate) }}" class="text-accent-teal hover:text-accent-teal-light">Edit</a>
                                
                                <form action="{{ route('admin.commission-rates.toggle', $rate) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-accent-teal hover:text-accent-teal-light">
                                        {{ $rate->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.commission-rates.destroy', $rate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this commission rate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="mt-4 p-4 bg-card rounded-lg text-gray-400">
            No course commission rates found.
        </div>
        @endif
    </div>
    
    <!-- Digital Products Commission Rates -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-white">Digital Product Commission Rates</h3>
        
        @if($productRates->count() > 0)
        <div class="mt-4 bg-card rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rate (%)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($productRates as $rate)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $rate->digitalProduct ? $rate->digitalProduct->name : 'Unknown Product' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $rate->rate }}%</td>
                        <td class="px-4 py-3 text-sm">
                            @if($rate->is_active)
                            <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Active</span>
                            @else
                            <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.commission-rates.edit', $rate) }}" class="text-accent-teal hover:text-accent-teal-light">Edit</a>
                                
                                <form action="{{ route('admin.commission-rates.toggle', $rate) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-accent-teal hover:text-accent-teal-light">
                                        {{ $rate->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.commission-rates.destroy', $rate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this commission rate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="mt-4 p-4 bg-card rounded-lg text-gray-400">
            No product commission rates found.
        </div>
        @endif
    </div>

    <!-- Add New Commission Rate -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-white">Add Commission Rate</h3>
        
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Courses Without Rates -->
            @if($coursesWithoutRates->count() > 0)
            <div class="bg-card rounded-lg p-4">
                <h4 class="text-accent-teal font-medium mb-2">Courses Without Commission Rates</h4>
                <ul class="space-y-2">
                    @foreach($coursesWithoutRates as $course)
                    <li class="flex justify-between items-center">
                        <span class="text-gray-300">{{ $course->title }}</span>
                        <a href="{{ route('admin.commission-rates.create', ['item_type' => 'course', 'item_id' => $course->id]) }}" class="text-accent-teal hover:text-accent-teal-light text-sm">Add Rate</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- Products Without Rates -->
            @if($productsWithoutRates->count() > 0)
            <div class="bg-card rounded-lg p-4">
                <h4 class="text-accent-teal font-medium mb-2">Products Without Commission Rates</h4>
                <ul class="space-y-2">
                    @foreach($productsWithoutRates as $product)
                    <li class="flex justify-between items-center">
                        <span class="text-gray-300">{{ $product->name }}</span>
                        <a href="{{ route('admin.commission-rates.create', ['item_type' => 'digital_product', 'item_id' => $product->id]) }}" class="text-accent-teal hover:text-accent-teal-light text-sm">Add Rate</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection