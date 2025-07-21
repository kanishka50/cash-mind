@extends('layouts.user')

@section('title', 'Payout History')

@section('content')
<div class="container px-4 py-8 mx-auto md:ml-64 content-transition w-auto max-w-full md:max-w-[calc(100%-16rem)]">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Payout History</h2>
        <a href="{{ route('user.referrals.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Dashboard
        </a>
    </div>
    
    @if(session('success'))
    <div class="mt-4 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mt-4 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif
    
    <!-- Balance Summary -->
    <div class="mt-6 glass-effect rounded-lg p-5 border border-gray-800">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <p class="text-gray-400 text-sm">Available Balance</p>
                <h3 class="text-2xl font-bold text-white mt-1">LKR {{ number_format($commission->balance, 2) }}</h3>
            </div>
            
            <div class="mt-4 md:mt-0">
                <a href="{{ route('user.referrals.payouts.request') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200 inline-block">Request Payout</a>
            </div>
        </div>
    </div>

    <!-- Payout Requests List -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
            </svg>
            Payout Requests
        </h3>
        
        @if($payouts->count() > 0)
        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
            <table class="w-full">
                <thead>
                    <tr class="bg-darker">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Request Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Payment Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Processing Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($payouts as $payout)
                    <tr class="hover:bg-card transition-colors duration-200">
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $payout->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">LKR {{ number_format($payout->amount, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $payout->payment_method }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($payout->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-md text-xs">Pending</span>
                            @elseif($payout->status === 'paid')
                            <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-400 rounded-md text-xs">Paid</span>
                            @elseif($payout->status === 'rejected')
                            <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-md text-xs">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $payout->processed_at ? \Carbon\Carbon::parse($payout->processed_at)->format('M d, Y') : '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            @if($payout->admin_notes)
                            <button type="button" class="text-accent-teal hover:text-accent-teal-light view-notes" data-notes="{{ $payout->admin_notes }}">View Notes</button>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $payouts->links() }}
        </div>
        @else
        <div class="p-4 glass-effect rounded-lg text-gray-400 border border-gray-800">
            No payout requests found. You can request a payout when you have a positive balance.
        </div>
        @endif
    </div>
</div>

<!-- Notes Modal -->
<div id="notes-modal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden">
    <div class="glass-effect rounded-lg max-w-md w-full p-6 border border-gray-800">
        <h3 class="text-lg font-medium text-white mb-4">Admin Notes</h3>
        
        <div class="bg-darker rounded-md p-4 mb-4">
            <p id="modal-notes-content" class="text-gray-300"></p>
        </div>
        
        <div class="flex justify-end">
            <button id="close-notes-modal" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">Close</button>
        </div>
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
        // Notes Modal
        const notesModal = document.getElementById('notes-modal');
        const closeNotesModal = document.getElementById('close-notes-modal');
        const modalNotesContent = document.getElementById('modal-notes-content');
        const viewNotesButtons = document.querySelectorAll('.view-notes');
        
        viewNotesButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notes = this.getAttribute('data-notes');
                modalNotesContent.textContent = notes;
                notesModal.classList.remove('hidden');
            });
        });
        
        if (closeNotesModal) {
            closeNotesModal.addEventListener('click', function() {
                notesModal.classList.add('hidden');
            });
        }
    });
</script>
@endpush
@endsection