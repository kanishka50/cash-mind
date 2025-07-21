<x-mail::message>
# Subscription Confirmation

Dear {{ $subscription->user->name }},

Thank you for subscribing to our {{ $subscription->subscriptionPlan->name }} plan. Your subscription has been successfully activated.

**Subscription Plan:** {{ $subscription->subscriptionPlan->name }}  
**Billing Cycle:** {{ ucfirst($subscription->billing_cycle) }}  
**Start Date:** {{ $subscription->starts_at->format('M d, Y') }}  
@if($subscription->ends_at)
**End Date:** {{ $subscription->ends_at->format('M d, Y') }}  
@else
**Next Billing Date:** {{ $subscription->starts_at->addMonth()->format('M d, Y') }}  
@endif
**Payment Method:** {{ ucfirst($subscription->payment_method) }}  

## Subscription Details

@if($subscription->billing_cycle === 'monthly')
**Monthly Price:** Rs. {{ number_format($subscription->subscriptionPlan->price_monthly, 2) }}  
@else
**Yearly Price:** Rs. {{ number_format($subscription->subscriptionPlan->price_yearly, 2) }}  
@endif

<x-mail::button :url="route('user.subscriptions.index')">
Manage Your Subscription
</x-mail::button>

You now have access to all the content included in your subscription plan. Visit your dashboard to start exploring.

If you have any questions about your subscription, please contact our support team.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>