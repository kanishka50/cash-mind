<?php

namespace App\Http\Middleware;

use App\Services\ReferralService;
use Closure;
use Illuminate\Http\Request;

class ReferralTrackingMiddleware
{
    protected $referralService;
    
    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if this is a new user registration
        if ($request->is('register') && $request->isMethod('post')) {
            // Store the referral code in the session for later use
            if ($referralCode = $this->referralService->getReferralCodeFromCookie()) {
                session(['referral_code' => $referralCode]);
            }
        }
        
        return $next($request);
    }
}