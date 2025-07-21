@extends('layouts.user')

@section('title', 'Digital Product Details')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Digital Product Details
        </h1>
        
        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
            <div class="p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-white">{{ $productKey->digitalProduct->name }}</h2>
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-accent-teal/20 text-accent-teal">
                        {{ ucfirst($productKey->digitalProduct->type) }}
                    </span>
                </div>
                
                <div class="mt-4">
                    <p class="text-gray-300 whitespace-pre-line">{{ $productKey->digitalProduct->description }}</p>
                </div>
                
                <div class="mt-6 border-t border-gray-800 pt-6">
                    <h3 class="text-md font-medium text-white mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Product Information
                    </h3>
                    
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <div class="flex justify-between items-center">
                            <p class="text-white font-medium">Your Key/Credentials</p>
                            <button id="copyBtn" class="text-sm text-accent-teal hover:text-accent-teal/80 transition-colors duration-200" onclick="copyToClipboard()">
                                Copy to Clipboard
                            </button>
                        </div>
                        
                        <div class="mt-3 p-3 bg-darker rounded font-mono text-sm overflow-x-auto text-gray-300 border border-gray-800" id="keyValue">
                            {{ $productKey->key_value }}
                        </div>
                        
                        <div class="mt-5 space-y-2">
                            <p class="text-gray-300"><span class="font-medium text-white">Type:</span> 
                                @if($productKey->digitalProduct->type === 'license_key')
                                    License Key
                                @elseif($productKey->digitalProduct->type === 'account_credentials')
                                    Account Credentials
                                @else
                                    Digital Asset
                                @endif
                            </p>
                            <p class="text-gray-300"><span class="font-medium text-white">Purchased On:</span> {{ $productKey->used_at->format('M d, Y') }}</p>
                            <p class="text-gray-300"><span class="font-medium text-white">Price:</span> <span class="text-accent-teal">Rs. {{ number_format($productKey->digitalProduct->price, 2) }}</span></p>
                        </div>
                    </div>
                </div>
                
                <!-- Usage Instructions Section - Example -->
                @if($productKey->digitalProduct->type === 'license_key')
                <div class="mt-8 border-t border-gray-800 pt-6">
                    <h3 class="text-md font-medium text-white mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Usage Instructions
                    </h3>
                    
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <ol class="list-decimal list-inside space-y-3 text-gray-300">
                            <li>Go to the product's official website</li>
                            <li>Download and install the software</li>
                            <li>During installation or first launch, look for the activation option</li>
                            <li>Enter the license key exactly as shown above</li>
                            <li>Click activate or verify to complete the process</li>
                        </ol>
                        
                        <p class="mt-4 text-sm text-gray-400">
                            Note: This key is for your personal use only. Please do not share it with others as it may lead to deactivation.
                        </p>
                    </div>
                </div>
                @elseif($productKey->digitalProduct->type === 'account_credentials')
                <div class="mt-8 border-t border-gray-800 pt-6">
                    <h3 class="text-md font-medium text-white mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Usage Instructions
                    </h3>
                    
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <ol class="list-decimal list-inside space-y-3 text-gray-300">
                            <li>Go to the service's website or open the app</li>
                            <li>Click on the "Sign In" or "Login" button</li>
                            <li>Enter the credentials exactly as shown above</li>
                            <li>The username and password are separated by a colon (:)</li>
                            <li>You may be asked to update the password on first login</li>
                        </ol>
                        
                        <p class="mt-4 text-sm text-gray-400">
                            Note: These credentials are for your personal use only. Please do not share them with others.
                        </p>
                    </div>
                </div>
                @endif
                
                <div class="mt-8 border-t border-gray-800 pt-6">
                    <h3 class="text-md font-medium text-white mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Need Help?
                    </h3>
                    
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <p class="text-gray-300 mb-5">
                            If you're having trouble with your digital product or need assistance, please contact our support team.
                        </p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('user.messages.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                Contact Support
                            </a>
                            
                            <a href="{{ route('user.digital-products.index') }}" class="inline-flex items-center px-4 py-2 bg-card border border-gray-800 text-white rounded-md hover:bg-darker transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const keyValue = document.getElementById('keyValue').textContent.trim();
        navigator.clipboard.writeText(keyValue).then(function() {
            const copyBtn = document.getElementById('copyBtn');
            copyBtn.textContent = 'Copied!';
            setTimeout(function() {
                copyBtn.textContent = 'Copy to Clipboard';
            }, 2000);
        });
    }
</script>
@endsection