<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use App\Models\UserCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('\App\Http\Middleware\AdminMiddleware');
    }
    
    /**
     * Display a listing of the payout requests.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        // Get payout requests based on status
        $payouts = PayoutRequest::with('user')
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        // Count by status
        $pendingCount = PayoutRequest::where('status', 'pending')->count();
        $paidCount = PayoutRequest::where('status', 'paid')->count();
        $rejectedCount = PayoutRequest::where('status', 'rejected')->count();
        
        return view('admin.payouts.index', compact(
            'payouts', 
            'status', 
            'pendingCount', 
            'paidCount', 
            'rejectedCount'
        ));
    }
    
    /**
     * Show the specified payout request.
     */
    public function show(PayoutRequest $payout)
    {
        $payout->load('user');
        
        return view('admin.payouts.show', compact('payout'));
    }
    
    /**
     * Process a payout request (mark as paid).
     */
    public function processPayout(Request $request, PayoutRequest $payout)
    {
        $request->validate([
            'admin_notes' => 'nullable|string'
        ]);
        
        // Check if the payout is already processed
        if ($payout->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payout request has already been processed.');
        }
        
        // Get the user's commission record
        $commission = UserCommission::where('user_id', $payout->user_id)->first();
        
        if (!$commission || $commission->balance < $payout->amount) {
            return redirect()->back()
                ->with('error', 'User has insufficient commission balance for this payout.');
        }
        
        // Mark the payout as paid
        $payout->markAsPaid(Auth::id(), $request->admin_notes);
        
        // Update all pending commission earnings to paid
        $user = $payout->user;
        $earningsToUpdate = $user->commissionEarnings()
            ->where('status', 'pending')
            ->get();
            
        foreach ($earningsToUpdate as $earning) {
            $earning->markAsPaid();
        }
        
        return redirect()->route('admin.payouts.index')
            ->with('success', 'Payout request processed successfully.');
    }
    
    /**
     * Reject a payout request.
     */
    public function rejectPayout(Request $request, PayoutRequest $payout)
    {
        $request->validate([
            'admin_notes' => 'required|string'
        ]);
        
        // Check if the payout is already processed
        if ($payout->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This payout request has already been processed.');
        }
        
        // Mark the payout as rejected
        $payout->markAsRejected(Auth::id(), $request->admin_notes);
        
        return redirect()->route('admin.payouts.index')
            ->with('success', 'Payout request rejected successfully.');
    }
}