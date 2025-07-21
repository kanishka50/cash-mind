<x-mail::message>
# Order Confirmation

Dear {{ $order->user->name }},

Thank you for your purchase. Your order has been confirmed and is being processed.

**Order Number:** {{ $order->order_number }}  
**Order Date:** {{ $order->created_at->format('M d, Y h:i A') }}  
**Payment Method:** {{ ucfirst($order->payment_method) }}  
**Payment Status:** {{ ucfirst($order->payment_status) }}  

## Order Summary

<x-mail::table>
| Item | Type | Price | Quantity | Total |
| ---- | ---- | ----- | -------- | ----- |
@foreach($order->orderItems as $item)
| {{ $item->item_name }} | {{ ucfirst($item->item_type) }} | Rs. {{ number_format($item->price, 2) }} | {{ $item->quantity }} | Rs. {{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
</x-mail::table>

@if($order->discount_amount > 0)
**Subtotal:** Rs. {{ number_format($order->total_amount, 2) }}  
**Discount:** Rs. {{ number_format($order->discount_amount, 2) }}  
@endif
**Total:** Rs. {{ number_format($order->final_amount, 2) }}  

@if($order->payment_status === 'completed')
You can access your purchased items from your dashboard.
@else
Your payment is currently being processed. You will receive another notification once it is completed.
@endif

<x-mail::button :url="route('user.orders.show', $order)">
View Order Details
</x-mail::button>

If you have any questions about your order, please contact our support team.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>