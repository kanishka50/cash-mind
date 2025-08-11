<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\UserSubscription;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share pending payments count with admin navigation
        View::composer('components.admin-nav', function ($view) {
            $pendingOrders = Order::whereNotNull('payment_receipt')
                                 ->where('payment_status', 'pending')
                                 ->count();
                                 
            $pendingSubscriptions = UserSubscription::whereNotNull('payment_receipt')
                                                   ->where('payment_status', 'pending')
                                                   ->count();
            
            $pendingPaymentsCount = $pendingOrders + $pendingSubscriptions;
            
            $view->with('pendingPaymentsCount', $pendingPaymentsCount);
        });
    }

    public function register()
    {
        //
    }
}