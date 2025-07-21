
@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Verify Your Email Address</h1>
            
            @if (session('resent'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>A fresh verification link has been sent to your email address.</p>
                </div>
            @endif
            
            <p class="text-gray-700 mb-4">
                Before proceeding, please check your email for a verification link.
                If you did not receive the email, click the button below to request another.
            </p>
            
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Send Verification Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection