@extends('layouts.user')

@section('title', 'Affiliate Dashboard')

@section('content')
<div class="container px-4 py-8 mx-auto md:ml-64 content-transition w-auto max-w-full md:max-w-[calc(100%-16rem)]">
    <h2 class="text-xl font-semibold text-white">Affiliate Dashboard</h2>
    
    @if(session('success'))
    <div class="mt-4 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
        <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mt-4 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md flex items-center">
        <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Earnings Overview -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <a href="{{ route('user.referrals.commissions') }}" class="text-accent-teal hover:text-accent-teal/80 text-sm flex items-center">
                    View Earnings History
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="glass-effect rounded-lg p-5 border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
            <p class="text-gray-400 text-sm">Referral Links</p>
            <h3 class="text-2xl font-bold text-white mt-2">{{ $referralLinks->count() }}</h3>
            <div class="mt-4">
                <a href="#generate-link" class="text-accent-teal hover:text-accent-teal/80 text-sm flex items-center">
                    Create New Link
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Referral Links -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            Your Referral Links
        </h3>
        
        @if($referralLinks->count() > 0)
        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Item</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Commission</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Clicks</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Conversions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($referralLinks as $link)
                    <tr class="hover:bg-card transition-colors duration-200">
                        <td class="px-4 py-3 text-sm text-gray-300">
                            @if($link->item_type === 'course' && $link->course)
                                {{ $link->course->title }}
                            @elseif($link->item_type === 'digital_product' && $link->digitalProduct)
                                {{ $link->digitalProduct->name }}
                            @else
                                Unknown Item
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $link->item_type === 'course' ? 'Course' : 'Digital Product' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            @if($link->item_type === 'course' && $link->course && $link->course->hasActiveCommissionRate())
                                <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">{{ $link->course->activeCommissionRate }}%</span>
                            @elseif($link->item_type === 'digital_product' && $link->digitalProduct && $link->digitalProduct->hasActiveCommissionRate())
                                <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">{{ $link->digitalProduct->activeCommissionRate }}%</span>
                            @else
                                <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $link->clicks }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $link->conversions }}</td>
                        <td class="px-4 py-3 text-sm">
                            <button class="text-accent-teal hover:text-accent-teal/80 flex items-center copy-link" data-url="{{ url('/ref/' . $link->referral_code) }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                </svg>
                                Copy Link
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-4 glass-effect rounded-lg text-gray-400 border border-gray-800">
            You haven't created any referral links yet. Generate your first link below.
        </div>
        @endif
    </div>

    <!-- Generate Referral Link -->
    <div id="generate-link" class="mt-8">
        <h3 class="text-lg font-medium text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Generate New Referral Link
        </h3>
        
        <div class="glass-effect rounded-lg p-6 border border-gray-800">
            <form action="{{ route('user.referrals.generate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="item_type" class="block text-sm font-medium text-gray-400 mb-2">Item Type</label>
                    <select id="item_type" name="item_type" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                        <option value="course">Course</option>
                        <option value="digital_product">Digital Product</option>
                    </select>
                </div>
                
                <div id="course-select" class="mb-4">
                    <label for="course_id" class="block text-sm font-medium text-gray-400 mb-2">Select Course</label>
                    <select id="course_id" name="item_id" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->activeCommissionRate }}%)</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="product-select" class="mb-4 hidden">
                    <label for="product_id" class="block text-sm font-medium text-gray-400 mb-2">Select Digital Product</label>
                    <select id="product_id" name="item_id" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal" disabled>
                        @foreach($digitalProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->activeCommissionRate }}%)</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        Generate Link
                    </button>
                </div>
            </form>
        </div>
    </div>

@if(session('referral_url'))
<div id="referral-link-modal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="glass-effect rounded-lg max-w-md w-full p-6 border border-gray-800">
        <h3 class="text-lg font-medium text-white mb-4">Your Referral Link</h3>
        
        <div class="flex items-center bg-darker rounded-md p-2 mb-4">
            <input type="text" id="referral-url" value="{{ session('referral_url') }}" class="bg-transparent border-0 text-gray-300 w-full focus:outline-none" readonly>
            <button id="copy-modal-btn" class="ml-2 px-3 py-1 bg-accent-teal text-white rounded-md text-sm hover:bg-opacity-90 transition duration-200">Copy</button>
        </div>
        
        <p class="text-sm text-gray-400 mb-4">Share this link with others to earn commissions when they make purchases.</p>
        
        <div class="flex justify-end">
            <button id="close-modal" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">Close</button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Item Type Selector
        const itemTypeSelect = document.getElementById('item_type');
        const courseSelect = document.getElementById('course-select');
        const productSelect = document.getElementById('product-select');
        const courseIdSelect = document.getElementById('course_id');
        const productIdSelect = document.getElementById('product_id');
        
        itemTypeSelect.addEventListener('change', function() {
            if (this.value === 'course') {
                courseSelect.classList.remove('hidden');
                productSelect.classList.add('hidden');
                courseIdSelect.removeAttribute('disabled');
                productIdSelect.setAttribute('disabled', 'disabled');
            } else {
                courseSelect.classList.add('hidden');
                productSelect.classList.remove('hidden');
                courseIdSelect.setAttribute('disabled', 'disabled');
                productIdSelect.removeAttribute('disabled');
            }
        });
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Success
            }).catch(err => {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();
                
                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.error('Failed to copy text: ', err);
                }
                
                document.body.removeChild(textarea);
            });
        }
        
        // Copy Link Buttons
        const copyButtons = document.querySelectorAll('.copy-link');
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                copyToClipboard(url);
                
                // Change button text temporarily
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                setTimeout(() => {
                    this.textContent = 'Copy Link';
                }, 2000);
            });
        });
        
        // Modal Handling
        const modal = document.getElementById('referral-link-modal');
        const closeModal = document.getElementById('close-modal');
        const copyModalBtn = document.getElementById('copy-modal-btn');
        
        if (modal && closeModal) {
            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            
            if (copyModalBtn) {
                copyModalBtn.addEventListener('click', function() {
                    const url = document.getElementById('referral-url').value;
                    copyToClipboard(url);
                    
                    // Change button text temporarily
                    this.textContent = 'Copied!';
                    setTimeout(() => {
                        this.textContent = 'Copy';
                    }, 2000);
                });
            }
        }
    });
</script>
@endpush
@endsection