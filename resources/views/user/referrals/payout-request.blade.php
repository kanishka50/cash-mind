@extends('layouts.user')

@section('title', 'Request Payout')

@section('content')
<div class="container px-4 py-8 mx-auto md:ml-64 content-transition w-auto max-w-full md:max-w-[calc(100%-16rem)]">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Request Payout</h2>
        <a href="{{ route('user.referrals.payouts') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Payouts
        </a>
    </div>
    
    @if(session('error'))
    <div class="mt-4 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <!-- Balance Information -->
    <div class="mt-6 glass-effect rounded-lg p-5 border border-gray-800">
        <p class="text-gray-400 text-sm">Available Balance</p>
        <h3 class="text-2xl font-bold text-white mt-1">LKR {{ number_format($commission->balance, 2) }}</h3>
    </div>

    <!-- Payout Request Form -->
    <div class="mt-8 glass-effect rounded-lg p-6 border border-gray-800">
        <h3 class="text-lg font-medium text-white mb-4">Request Payout</h3>
        
        <form action="{{ route('user.referrals.payouts.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-400 mb-2">Amount (LKR)</label>
                <input type="number" id="amount" name="amount" min="1" max="{{ $commission->balance }}" value="{{ old('amount', $commission->balance) }}" step="0.01" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                @error('amount')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Maximum: LKR {{ number_format($commission->balance, 2) }}</p>
            </div>
            
            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-gray-400 mb-2">Payment Method</label>
                <select id="payment_method" name="payment_method" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="paypal">PayPal</option>
                    <option value="payoneer">Payoneer</option>
                    <option value="other">Other</option>
                </select>
                @error('payment_method')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="payment_details" class="block text-sm font-medium text-gray-400 mb-2">Payment Details</label>
                <textarea id="payment_details" name="payment_details" rows="4" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal" placeholder="Enter your payment details (account number, email, etc.)">{{ old('payment_details') }}</textarea>
                @error('payment_details')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="p-4 mb-6 bg-darker rounded-lg">
                <p class="text-sm text-gray-400">
                    <strong class="text-white">Note:</strong> Payouts are typically processed within 7 business days. You will receive a notification once your payout has been processed.
                </p>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Submit Payout Request
                </button>
            </div>
        </form>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodSelect = document.getElementById('payment_method');
        const paymentDetailsTextarea = document.getElementById('payment_details');
        
        paymentMethodSelect.addEventListener('change', function() {
            let placeholder = '';
            
            switch(this.value) {
                case 'bank_transfer':
                    placeholder = 'Bank Name:\nAccount Holder Name:\nAccount Number:\nBranch:\nIFSC/SWIFT Code:';
                    break;
                case 'paypal':
                    placeholder = 'PayPal Email Address:';
                    break;
                case 'payoneer':
                    placeholder = 'Payoneer Email Address:';
                    break;
                case 'other':
                    placeholder = 'Please provide detailed information about your preferred payment method:';
                    break;
            }
            
            paymentDetailsTextarea.placeholder = placeholder;
        });
        
        // Trigger the change event to set the initial placeholder
        paymentMethodSelect.dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection