<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserSubscription;

class NotificationService
{
    /**
     * Create a new notification.
     *
     * @param int $userId
     * @param string $type
     * @param string $title
     * @param string|null $content
     * @param array|null $data
     * @return Notification
     */
    public function create(int $userId, string $type, string $title, ?string $content = null, ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'data' => $data,
            'is_read' => false,
        ]);
    }

    /**
     * Create a welcome notification for a new user.
     *
     * @param User $user
     * @return Notification
     */
    public function createWelcomeNotification(User $user): Notification
    {
        return $this->create(
            $user->id,
            'welcome',
            'Welcome to Cash Mind',
            'Thank you for joining our platform. Start exploring our courses and digital products to enhance your financial knowledge.',
            ['url' => route('home')]
        );
    }

    /**
     * Create a notification for subscription expiration.
     *
     * @param UserSubscription $subscription
     * @return Notification
     */
    public function createSubscriptionExpiringNotification(UserSubscription $subscription): Notification
    {
        $daysLeft = now()->diffInDays($subscription->ends_at);
        
        return $this->create(
            $subscription->user_id,
            'subscription_expiring',
            'Your Subscription is Expiring Soon',
            "Your {$subscription->subscriptionPlan->name} subscription will expire in {$daysLeft} days. Renew now to keep your access.",
            [
                'subscription_id' => $subscription->id,
                'days_left' => $daysLeft,
                'url' => route('subscription-plans.index')
            ]
        );
    }

    /**
     * Create a notification for new course addition to subscription.
     *
     * @param UserSubscription $subscription
     * @param int $courseId
     * @param string $courseTitle
     * @return Notification
     */
    public function createNewCourseAddedNotification(UserSubscription $subscription, int $courseId, string $courseTitle): Notification
    {
        return $this->create(
            $subscription->user_id,
            'new_course_added',
            'New Course Added to Your Subscription',
            "A new course '{$courseTitle}' has been added to your {$subscription->subscriptionPlan->name} subscription.",
            [
                'course_id' => $courseId,
                'url' => route('courses.show', ['slug' => $courseId]) // This should be updated with the actual course slug
            ]
        );
    }

    /**
     * Create a notification for successful purchase.
     *
     * @param int $userId
     * @param string $itemType
     * @param string $itemName
     * @param int $orderId
     * @return Notification
     */
    public function createPurchaseSuccessNotification(int $userId, string $itemType, string $itemName, int $orderId): Notification
    {
        return $this->create(
            $userId,
            'purchase_success',
            'Purchase Successful',
            "Your purchase of {$itemName} was successful.",
            [
                'item_type' => $itemType,
                'order_id' => $orderId,
                'url' => route('user.orders.show', $orderId)
            ]
        );
    }

    /**
     * Mark a notification as read.
     *
     * @param Notification $notification
     * @return bool
     */
    public function markAsRead(Notification $notification): bool
    {
        return $notification->update(['is_read' => true]);
    }

    /**
     * Mark all notifications for a user as read.
     *
     * @param int $userId
     * @return bool
     */
    public function markAllAsRead(int $userId): bool
    {
        return Notification::where('user_id', $userId)
            ->update(['is_read' => true]);
    }
}