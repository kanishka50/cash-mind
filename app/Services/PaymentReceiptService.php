<?php
namespace App\Services;

use App\Models\Order;
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
            
            // Calculate subscription dates
            $startsAt = now();
            $endsAt = $subscription->billing_cycle === 'yearly' 
                ? $startsAt->copy()->addYear() 
                : $startsAt->copy()->addMonth();
            
            // Update subscription status
            $subscription->update([
                'payment_status' => 'completed',
                'payment_verified_by' => $adminId,
                'payment_verified_at' => now(),
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_active' => true,
                'admin_notes' => $notes
            ]);
            
            // IMPORTANT: Grant access to subscription content
            $this->grantSubscriptionContentAccess($subscription);
            
            DB::commit();
            
            // Notify user
            $this->notifyUserSubscriptionStatus($subscription, 'verified');
            
            Log::info('Subscription payment verified and content access granted', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'admin_id' => $adminId
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
    protected function grantSubscriptionContentAccess(UserSubscription $subscription)
    {
        $user = $subscription->user;
        $subscriptionPlan = $subscription->subscriptionPlan;
        
        // Grant access to all courses in the subscription plan
        $courses = $subscriptionPlan->courses;
        foreach ($courses as $course) {
            // Check if user already has access to this course
            $existingAccess = UserCourse::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
            
            if (!$existingAccess) {
                UserCourse::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'subscription_id' => $subscription->id, // Track that this came from subscription
                ]);
                
                Log::info('Course access granted via subscription', [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'subscription_id' => $subscription->id
                ]);
            }
        }
        
        // Assign product keys for digital products in the subscription plan
        $digitalProducts = $subscriptionPlan->digitalProducts;
        foreach ($digitalProducts as $product) {
            // Check if user already has a key for this product
            $existingKey = ProductKey::where('digital_product_id', $product->id)
                ->where('used_by', $user->id)
                ->first();
            
            if (!$existingKey) {
                // Find an available key
                $availableKey = ProductKey::where('digital_product_id', $product->id)
                    ->where('is_used', false)
                    ->first();
                
                if ($availableKey) {
                    // Mark the key as used by this user
                    $availableKey->update([
                        'is_used' => true,
                        'used_by' => $user->id,
                        'used_at' => now(),
                        'subscription_assigned' => true, // Mark that this was assigned via subscription
                    ]);
                    
                    // Update product inventory count
                    $product->update([
                        'inventory_count' => $product->availableKeys()->count()
                    ]);
                    
                    Log::info('Product key assigned via subscription', [
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'key_id' => $availableKey->id,
                        'subscription_id' => $subscription->id
                    ]);
                } else {
                    Log::warning('No available keys for digital product in subscription', [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'subscription_id' => $subscription->id,
                        'user_id' => $user->id
                    ]);
                }
            }
        }
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