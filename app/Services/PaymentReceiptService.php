<?php
namespace App\Services;

use App\Models\Order;
use App\Models\User;  // ADD THIS LINE - This was missing!
use App\Models\UserSubscription;
use App\Models\UserCourse;
use App\Models\ProductKey;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentReceiptService
{
    /**
     * Handle receipt upload for an order.
     *
     * @param UploadedFile $file
     * @param Order $order
     * @return string
     */
    public function handleReceiptUpload(UploadedFile $file, Order $order)
    {
        // Generate unique filename
        $filename = $this->generateFilename($file, 'order', $order->id);
        
        // Store file in private storage
        $path = $file->storeAs(
            'payment_receipts/orders/' . date('Y/m'),
            $filename,
            'private'
        );
        
        // Update order with receipt info
        $order->update([
            'payment_receipt' => $path,
            'payment_receipt_uploaded_at' => now()
        ]);
        
        return $path;
    }
    
    /**
     * Handle receipt upload for a subscription.
     *
     * @param UploadedFile $file
     * @param UserSubscription $subscription
     * @return string
     */
    public function handleSubscriptionReceiptUpload(UploadedFile $file, UserSubscription $subscription)
    {
        // Generate unique filename
        $filename = $this->generateFilename($file, 'subscription', $subscription->id);
        
        // Store file in private storage
        $path = $file->storeAs(
            'payment_receipts/subscriptions/' . date('Y/m'),
            $filename,
            'private'
        );
        
        // Update subscription with receipt info
        $subscription->update([
            'payment_receipt' => $path,
            'payment_receipt_uploaded_at' => now()
        ]);
        
        return $path;
    }
    
    /**
     * Verify payment for an order.
     *
     * @param Order $order
     * @param int $adminId
     * @param string|null $notes
     * @return Order
     */
    public function verifyPayment(Order $order, $adminId, $notes = null)
    {
        $order->update([
            'payment_status' => 'completed',
            'payment_verified_by' => $adminId,
            'payment_verified_at' => now(),
            'admin_notes' => $notes
        ]);
        
        // Complete the order and grant access
        app(OrderService::class)->completeOrder($order);
        
        // Notify user
        $this->notifyUserPaymentStatus($order, 'verified');
        
        return $order;
    }
    
    /**
     * Verify payment for a subscription and grant access to content.
     *
     * @param UserSubscription $subscription
     * @param int $adminId
     * @param string|null $notes
     * @return UserSubscription
     */
    public function verifySubscriptionPayment(UserSubscription $subscription, $adminId, $notes = null)
    {
        try {
            DB::beginTransaction();
            
            // Step 1: Deactivate all other active subscriptions
            UserSubscription::where('user_id', $subscription->user_id)
                ->where('id', '!=', $subscription->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'ends_at' => now(),
                    'admin_notes' => 'Deactivated due to new subscription activation'
                ]);
            
            // Step 2: Revoke all existing subscription-based access
            $this->revokeUserSubscriptionAccess($subscription->user);
            
            // Step 3: Calculate subscription dates
            $startsAt = now();
            $endsAt = $subscription->billing_cycle === 'yearly' 
                ? $startsAt->copy()->addYear() 
                : $startsAt->copy()->addMonth();
            
            // Step 4: Update subscription status
            $subscription->update([
                'payment_status' => 'completed',
                'payment_verified_by' => $adminId,
                'payment_verified_at' => now(),
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_active' => true,
                'admin_notes' => $notes
            ]);
            
            // Step 5: Grant new subscription access
            $this->grantSubscriptionContentAccess($subscription);
            
            DB::commit();
            
            // Notify user
            $this->notifyUserSubscriptionStatus($subscription, 'verified');
            
            Log::info('Subscription verified, old access revoked, new access granted', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'admin_id' => $adminId,
                'expires_at' => $endsAt
            ]);
            
            return $subscription;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to verify subscription payment', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
    
    /**
     * Grant access to all courses and digital products in the subscription plan.
     *
     * @param UserSubscription $subscription
     * @return void
     */
    // protected function grantSubscriptionContentAccess(UserSubscription $subscription)
    // {
    //     $user = $subscription->user;
    //     $subscriptionPlan = $subscription->subscriptionPlan;
    //     $expiresAt = $subscription->ends_at;
        
    //     // Grant access to all courses in the subscription plan
    //     $courses = $subscriptionPlan->courses;
    //     foreach ($courses as $course) {
    //         UserCourse::create([
    //             'user_id' => $user->id,
    //             'course_id' => $course->id,
    //             'subscription_id' => $subscription->id,
    //             'access_type' => 'subscription',        // NEW
    //             'expires_at' => $expiresAt,            // NEW
    //             'purchased_at' => now(),
    //         ]);
            
    //         Log::info('Course access granted via subscription', [
    //             'user_id' => $user->id,
    //             'course_id' => $course->id,
    //             'subscription_id' => $subscription->id,
    //             'expires_at' => $expiresAt
    //         ]);
    //     }
        
    //     // Assign product keys for digital products
    //     $digitalProducts = $subscriptionPlan->digitalProducts;
    //     foreach ($digitalProducts as $digitalProduct) {
    //         // Find an available key
    //         $availableKey = ProductKey::where('digital_product_id', $digitalProduct->id)
    //             ->where('is_used', false)
    //             ->lockForUpdate()
    //             ->first();
            
    //         if ($availableKey) {
    //             // Mark the key as used with expiry
    //             $availableKey->markAsUsed(
    //                 $user->id, 
    //                 true,                   // subscription assigned
    //                 $subscription->id,      // subscription ID
    //                 $expiresAt             // expires at
    //             );
                
    //             Log::info('Product key assigned via subscription', [
    //                 'user_id' => $user->id,
    //                 'product_id' => $digitalProduct->id,
    //                 'key_id' => $availableKey->id,
    //                 'subscription_id' => $subscription->id,
    //                 'expires_at' => $expiresAt
    //             ]);
    //         } else {
    //             Log::warning('No available keys for subscription product', [
    //                 'user_id' => $user->id,
    //                 'product_id' => $digitalProduct->id,
    //                 'subscription_id' => $subscription->id
    //             ]);
    //         }
    //     }
    // }
 // In app/Services/PaymentReceiptService.php

protected function grantSubscriptionContentAccess(UserSubscription $subscription)
{
    $user = $subscription->user;
    $subscriptionPlan = $subscription->subscriptionPlan;
    $expiresAt = $subscription->ends_at;
    
    // DON'T create UserCourse records - keep courses dynamic
    
    // BUT DO assign product keys immediately for all products in the plan
    $digitalProducts = $subscriptionPlan->digitalProducts;
    foreach ($digitalProducts as $digitalProduct) {
        // Check if user already has a key for this product
        $existingKey = ProductKey::where('digital_product_id', $digitalProduct->id)
            ->where('used_by', $user->id)
            ->first();
        
        if (!$existingKey) {
            // Find an available key
            $availableKey = ProductKey::where('digital_product_id', $digitalProduct->id)
                ->where('is_used', false)
                ->lockForUpdate()
                ->first();
            
            if ($availableKey) {
                // Assign the key with subscription info
                $availableKey->update([
                    'is_used' => true,
                    'used_by' => $user->id,
                    'used_at' => now(),
                    'subscription_assigned' => true,
                    'subscription_id' => $subscription->id,
                    'expires_at' => $expiresAt
                ]);
                
                Log::info('Product key assigned via subscription', [
                    'user_id' => $user->id,
                    'product_id' => $digitalProduct->id,
                    'key_id' => $availableKey->id,
                    'subscription_id' => $subscription->id
                ]);
            } else {
                Log::warning('No available keys for subscription product', [
                    'user_id' => $user->id,
                    'product_id' => $digitalProduct->id,
                    'subscription_id' => $subscription->id
                ]);
            }
        }
    }
    
    Log::info('Subscription activated', [
        'subscription_id' => $subscription->id,
        'user_id' => $user->id,
        'keys_assigned' => $digitalProducts->count()
    ]);
}
    
    /**
     * Revoke all subscription-based access for a user.
     *
     * @param User $user
     * @return void
     */
    protected function revokeUserSubscriptionAccess(User $user)
    {
        // Delete all subscription-based course access
        $deletedCourses = UserCourse::where('user_id', $user->id)
            ->where('access_type', 'subscription')
            ->delete();
        
        // Reset all subscription-assigned product keys
        $resetKeys = ProductKey::where('used_by', $user->id)
            ->where('subscription_assigned', true)
            ->get();
        
        foreach ($resetKeys as $key) {
            $key->resetKey();
        }
        
        Log::info('Revoked subscription access', [
            'user_id' => $user->id,
            'courses_removed' => $deletedCourses,
            'keys_reset' => $resetKeys->count()
        ]);
    }
    
    /**
     * Reject payment for an order.
     *
     * @param Order $order
     * @param int $adminId
     * @param string $reason
     * @return Order
     */
    public function rejectPayment(Order $order, $adminId, $reason)
    {
        $order->update([
            'payment_status' => 'failed',
            'payment_verified_by' => $adminId,
            'payment_verified_at' => now(),
            'admin_notes' => $reason
        ]);
        
        // Notify user
        $this->notifyUserPaymentStatus($order, 'rejected', $reason);
        
        return $order;
    }
    
    /**
     * Reject payment for a subscription.
     *
     * @param UserSubscription $subscription
     * @param int $adminId
     * @param string $reason
     * @return UserSubscription
     */
    public function rejectSubscriptionPayment(UserSubscription $subscription, $adminId, $reason)
    {
        $subscription->update([
            'payment_status' => 'failed',
            'payment_verified_by' => $adminId,
            'payment_verified_at' => now(),
            'admin_notes' => $reason
        ]);
        
        // Notify user
        $this->notifyUserSubscriptionStatus($subscription, 'rejected', $reason);
        
        return $subscription;
    }
    
    /**
     * Get payment receipt file response.
     *
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getReceiptResponse($path)
    {
        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Receipt not found');
        }

        $fullPath = Storage::disk('private')->path($path);
        return response()->file($fullPath);
    }
    
    /**
     * Delete payment receipt.
     *
     * @param string $path
     * @return bool
     */
    public function deleteReceipt($path)
    {
        return Storage::disk('private')->delete($path);
    }
    
    /**
     * Generate unique filename for receipt.
     *
     * @param UploadedFile $file
     * @param string $type
     * @param int $id
     * @return string
     */
    protected function generateFilename(UploadedFile $file, $type, $id)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = Str::random(6);
        
        return "{$type}_{$id}_{$timestamp}_{$random}.{$extension}";
    }
    
    /**
     * Notify user about payment status (placeholder for future implementation).
     *
     * @param Order $order
     * @param string $status
     * @param string|null $reason
     * @return void
     */
    protected function notifyUserPaymentStatus(Order $order, $status, $reason = null)
    {
        // TODO: Implement email notification
        // For now, this is a placeholder
        Log::info("Payment {$status} for order {$order->order_number}", [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'reason' => $reason
        ]);
    }
    
    /**
     * Notify user about subscription payment status (placeholder for future implementation).
     *
     * @param UserSubscription $subscription
     * @param string $status
     * @param string|null $reason
     * @return void
     */
    protected function notifyUserSubscriptionStatus(UserSubscription $subscription, $status, $reason = null)
    {
        // TODO: Implement email notification
        // For now, this is a placeholder
        Log::info("Subscription payment {$status}", [
            'subscription_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'reason' => $reason
        ]);
    }
    
    /**
     * Get bank details for display.
     *
     * @return array
     */
    public function getBankDetails()
    {
        return [
            'bank_name' => env('BANK_NAME', 'Commercial Bank of Ceylon'),
            'account_name' => env('BANK_ACCOUNT_NAME', 'Cash Mind Pvt Ltd'),
            'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
            'branch' => env('BANK_BRANCH', 'Colombo'),
            'swift_code' => env('BANK_SWIFT_CODE', ''),
        ];
    }
    
    /**
     * Validate receipt file.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function validateReceiptFile(UploadedFile $file)
    {
        // Check file size (5MB max)
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('File size must not exceed 5MB');
        }
        
        // Check file type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('File must be JPG, PNG, or PDF format');
        }
        
        return true;
    }
}