<!-- resources/views/admin/payouts/show.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Payout Request Details</h2>
        <a href="{{ route('admin.payouts.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Payouts
        </a>
    </div>

    @if(session('error'))
    <div class="mt-4 p-4 bg-red-500 bg-opacity-20 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <!-- Payout Request Details -->
    <div class="mt-8 bg-card rounded-lg p-6">
        <h3 class="text-lg font-medium text-white mb-4">Request Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-400 mb-2">Request ID: <span class="text-white">{{ $payout->id }}</span></p>
                <p class="text-gray-400 mb-2">User: <span class="text-white">{{ $payout->user->name }}</span></p>
                <p class="text-gray-400 mb-2">Email: <span class="text-white">{{ $payout->user->email }}</span></p>
                <p class="text-gray-400 mb-2">Amount: <span class="text-white">LKR {{ number_format($payout->amount, 2) }}</span></p>
                <p class="text-gray-400 mb-2">Payment Method: <span class="text-white">{{ $payout->payment_method }}</span></p>
            </div>
            <div>
                <p class="text-gray-400 mb-2">Status: 
                    @if($payout->status === 'pending')
                    <span class="px-2 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-md text-xs">Pending</span>
                    @elseif($payout->status === 'paid')
                    <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Paid</span>
                    @elseif($payout->status === 'rejected')
                    <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Rejected</span>
                    @endif
                </p>
                <p class="text-gray-400 mb-2">Requested On: <span class="text-white">{{ $payout->created_at->format('M d, Y H:i') }}</span></p>
                
                @if($payout->processed_at)
                <p class="text-gray-400 mb-2">Processed On: <span class="text-white">{{ \Carbon\Carbon::parse($payout->processed_at)->format('M d, Y H:i') }}</span></p>
                <p class="text-gray-400 mb-2">Processed By: <span class="text-white">{{ $payout->processedByUser ? $payout->processedByUser->name : 'Unknown' }}</span></p>
                @endif
            </div>
        </div>
        
        <div class="mt-4">
            <h4 class="text-white font-medium mb-2">Payment Details</h4>
            <div class="p-4 bg-darker rounded-lg text-gray-300">
                @php
                    $paymentDetails = json_decode($payout->payment_details, true);
                @endphp
                
                @if(isset($paymentDetails['details']))
                    {{ $paymentDetails['details'] }}
                @else
                    @foreach($paymentDetails as $key => $value)
                        <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        
        @if($payout->admin_notes)
        <div class="mt-4">
            <h4 class="text-white font-medium mb-2">Admin Notes</h4>
            <div class="p-4 bg-darker rounded-lg text-gray-300">
                {{ $payout->admin_notes }}
            </div>
        </div>
        @endif
        
        @if($payout->status === 'pending')
        <div class="mt-6 border-t border-gray-800 pt-6">
            <div class="flex space-x-4">
                <button onclick="showProcessForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                    Process Payout
                </button>
                <button onclick="showRejectForm()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                    Reject Payout
                </button>
            </div>
            
            <!-- Process Payout Form -->
            <div id="process-form" class="hidden mt-4 p-4 bg-darker rounded-lg">
                <h4 class="text-white font-medium mb-3">Process Payout</h4>
                <form action="{{ route('admin.payouts.process', $payout) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-400 mb-1">Admin Notes (Optional)</label>
                        <textarea id="admin_notes" name="admin_notes" rows="3" class="w-full bg-card border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal"></textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" onclick="hideProcessForm()" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200 mr-2">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Reject Payout Form -->
            <div id="reject-form" class="hidden mt-4 p-4 bg-darker rounded-lg">
                <h4 class="text-white font-medium mb-3">Reject Payout</h4>
                <form action="{{ route('admin.payouts.reject', $payout) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="reject_admin_notes" class="block text-sm font-medium text-gray-400 mb-1">Reason for Rejection (Required)</label>
                        <textarea id="reject_admin_notes" name="admin_notes" rows="3" class="w-full bg-card border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal" required></textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" onclick="hideRejectForm()" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200 mr-2">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                            Confirm Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function showProcessForm() {
        document.getElementById('process-form').classList.remove('hidden');
        document.getElementById('reject-form').classList.add('hidden');
    }
    
    function hideProcessForm() {
        document.getElementById('process-form').classList.add('hidden');
    }
    
    function showRejectForm() {
        document.getElementById('reject-form').classList.remove('hidden');
        document.getElementById('process-form').classList.add('hidden');
    }
    
    function hideRejectForm() {
        document.getElementById('reject-form').classList.add('hidden');
    }
</script>
@endsection