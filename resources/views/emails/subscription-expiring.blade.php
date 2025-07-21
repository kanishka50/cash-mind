@component('mail::message')
# Your Subscription is Expiring Soon

Hi {{ $user->name }},

Your {{ $subscription->subscriptionPlan->name }} subscription will expire on **{{ $subscription->ends_at->format('F j, Y') }}**.

Don't miss out on our premium content and exclusive resources. Renew your subscription now to maintain uninterrupted access to all our financial education materials.

@component('mail::button', ['url' => route('user.subscriptions.index')])
Renew Subscription
@endcomponent

## Your Current Subscription Details:
- **Plan**: {{ $subscription->subscriptionPlan->name }}
- **Billing Cycle**: {{ ucfirst($subscription->billing_cycle) }}
- **Expiration Date**: {{ $subscription->ends_at->format('F j, Y') }}

If you choose not to renew, you'll still have access to all previously purchased individual courses, but subscription-exclusive content will no longer be available after the expiration date.

Thank you for being a valued member of the Cash Mind community!

Best regards,<br>
The Cash Mind Team
@endcomponent