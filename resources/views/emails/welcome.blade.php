@component('mail::message')
# Welcome to Cash Mind!

Hi {{ $user->name }},

Thank you for joining Cash Mind, your platform for financial education in Sri Lanka. We're excited to have you on board!

Here's what you can do with your new account:
- Access our financial education courses
- Learn investment strategies and economic insights
- Get exclusive content with a subscription
- Purchase digital products to enhance your financial skills

@component('mail::button', ['url' => route('home')])
Explore Our Courses
@endcomponent

If you have any questions or need assistance, feel free to contact our support team.

Best regards,<br>
The Cash Mind Team
@endcomponent