<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\CourseController as UserCourseController;
use App\Http\Controllers\User\VideoController as UserVideoController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\ProfileController;

// New imports for Phase 3
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DigitalProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\DigitalProductController as AdminDigitalProductController;
use App\Http\Controllers\Admin\ProductKeyController as AdminProductKeyController;
use App\Http\Controllers\User\SubscriptionController as UserSubscriptionController;
use App\Http\Controllers\User\DigitalProductController as UserDigitalProductController;

use App\Http\Controllers\User\ProfileController as UserProfileController;   



// Phase 5 controllers
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\NotificationController;

use App\Http\Controllers\Admin\PaymentVerificationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');

// Course routes - Phase 2
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Temp routes for Phase 3 features - these will be implemented later
// Subscription routes
Route::get('/subscription-plans', [SubscriptionController::class, 'index'])->name('subscription-plans.index');
Route::post('/subscription-plans/{subscriptionPlan}/checkout', [SubscriptionController::class, 'checkout'])
    ->middleware('auth', 'verified')
    ->name('subscription-plans.checkout');

// Digital products routes
Route::get('/digital-products', [DigitalProductController::class, 'index'])->name('digital-products.index');
Route::get('/digital-products/{digitalProduct}', [DigitalProductController::class, 'show'])->name('digital-products.show');

// Payment success callbacks
Route::get('/payment/subscription/success', [SubscriptionController::class, 'handleSuccess'])->name('payment.subscription.success');



// Authentication routes
Auth::routes(['verify' => true]);

// Google login
Route::get('/login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard - Phase 1
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Categories - Phase 2
    Route::resource('categories', AdminCategoryController::class);
    
    // Tags - Phase 2
    Route::resource('tags', AdminTagController::class);
    
    // Courses - Phase 2
    Route::resource('courses', AdminCourseController::class);
    Route::get('courses/{course}/videos', [AdminCourseController::class, 'videos'])->name('courses.videos');
    
    // Videos - Phase 2
    Route::resource('videos', AdminVideoController::class);
    Route::post('videos/upload-chunk', [AdminVideoController::class, 'uploadChunk'])->name('videos.upload-chunk');
    Route::post('videos/complete-upload', [AdminVideoController::class, 'completeUpload'])->name('videos.complete-upload');
    
    // Phase 3 routes (placeholders)
  // Subscription routes
    Route::resource('subscriptions', AdminSubscriptionController::class);
    
    // Digital products routes
    Route::resource('digital-products', AdminDigitalProductController::class);
    
    // Product keys routes
    Route::get('digital-products/{digitalProduct}/keys', [AdminProductKeyController::class, 'index'])->name('digital-products.keys');
    Route::post('digital-products/{digitalProduct}/keys', [AdminProductKeyController::class, 'store'])->name('digital-products.keys.store');
    Route::delete('digital-products/{digitalProduct}/keys/{key}', [AdminProductKeyController::class, 'destroy'])->name('digital-products.keys.destroy');

    // Route::view('/coupons', 'admin.coupons.index')->name('coupons.index');
    // Route::view('/coupons/create', 'admin.coupons.create')->name('coupons.create');
    // Route::view('/coupons/{id}/edit', 'admin.coupons.edit')->name('coupons.edit');

    Route::view('/orders', 'admin.orders.index')->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    // User management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Messages
    Route::get('/messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [App\Http\Controllers\Admin\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');

    Route::view('/faqs', 'admin.faqs.index')->name('faqs.index');
    Route::view('/faqs/create', 'admin.faqs.create')->name('faqs.create');
    Route::view('/faqs/{id}/edit', 'admin.faqs.edit')->name('faqs.edit');

    // Subscription content management
    Route::get('subscriptions/{subscription}/manage-content', [AdminSubscriptionController::class, 'manageContent'])
        ->name('subscriptions.manage-content');
    Route::post('subscriptions/{subscription}/update-content', [AdminSubscriptionController::class, 'updateContent'])
        ->name('subscriptions.update-content');



    // User profile picture update routes
    Route::patch('users/{user}/update-picture', [UserController::class, 'updatePicture'])->name('users.update-picture');
    Route::get('users/{user}/delete-picture', [UserController::class, 'deletePicture'])->name('users.delete-picture');



        // Coupon management
    Route::resource('coupons', CouponController::class);
    
    // Order management
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::put('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

     // Commission rates management
    Route::resource('commission-rates', App\Http\Controllers\Admin\CommissionRateController::class);
    Route::post('commission-rates/{commissionRate}/toggle', [App\Http\Controllers\Admin\CommissionRateController::class, 'toggleActive'])->name('commission-rates.toggle');
    
    // Payout management
    Route::get('payouts', [App\Http\Controllers\Admin\PayoutController::class, 'index'])->name('payouts.index');
    Route::get('payouts/{payout}', [App\Http\Controllers\Admin\PayoutController::class, 'show'])->name('payouts.show');
    Route::post('payouts/{payout}/process', [App\Http\Controllers\Admin\PayoutController::class, 'processPayout'])->name('payouts.process');
    Route::post('payouts/{payout}/reject', [App\Http\Controllers\Admin\PayoutController::class, 'rejectPayout'])->name('payouts.reject');
});

// User routes
Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
   
    // Dashboard - Phase 1
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Profile management
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/delete-picture', [UserProfileController::class, 'deleteProfilePicture'])->name('profile.delete-picture');
    
    // Profile picture update routes
    Route::patch('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');

    // Courses - Phase 2
    Route::get('/courses', [UserCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [UserCourseController::class, 'show'])
        // ->middleware('verify.course.purchased')
        ->name('courses.show');
    
    // Videos - Phase 2
    Route::get('/videos/{video}', [UserVideoController::class, 'show'])->name('videos.show');
    Route::post('/videos/{video}/progress', [UserVideoController::class, 'updateProgress'])->name('videos.progress');
    
    // Phase 3 routes (placeholders)
    // Subscription routes
    Route::get('/subscriptions', [UserSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/manage', [UserSubscriptionController::class, 'manage'])->name('subscriptions.manage');
    Route::post('/subscriptions/cancel', [UserSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    
    // Digital products routes
    Route::get('/digital-products', [UserDigitalProductController::class, 'index'])->name('digital-products.index');
    Route::get('/digital-products/{productKey}', [UserDigitalProductController::class, 'show'])->name('digital-products.show');

    // Route::view('/orders', 'user.orders.index')->name('orders.index');
    // Route::view('/orders/{id}', 'user.orders.show')->name('orders.show');

    Route::view('/wishlist', 'user.wishlist.index')->name('wishlist.index');
    Route::post('/wishlist/toggle', function() {
        return redirect()->back()->with('success', 'Wishlist updated');
    })->name('wishlist.toggle');

 
    // Messages
    Route::get('/messages', [App\Http\Controllers\User\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [App\Http\Controllers\User\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [App\Http\Controllers\User\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [App\Http\Controllers\User\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [App\Http\Controllers\User\MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [App\Http\Controllers\User\MessageController::class, 'destroy'])->name('messages.destroy');


    // Notifications
    Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/mark-read', [App\Http\Controllers\User\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\User\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');



       // Order routes
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

     Route::get('/digital-products/subscription/{digitalProduct}', [UserDigitalProductController::class, 'showSubscriptionProduct'])
    ->name('digital-products.subscription.show');

    // Add these routes to your existing user routes group
    Route::prefix('referrals')->name('referrals.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\ReferralController::class, 'index'])->name('index');
        Route::post('/generate', [App\Http\Controllers\User\ReferralController::class, 'generateLink'])->name('generate');
        Route::get('/commissions', [App\Http\Controllers\User\ReferralController::class, 'commissions'])->name('commissions');
        Route::get('/payouts', [App\Http\Controllers\User\ReferralController::class, 'payouts'])->name('payouts');
        Route::get('/payouts/request', [App\Http\Controllers\User\ReferralController::class, 'showPayoutForm'])->name('payouts.request');
        Route::post('/payouts/request', [App\Http\Controllers\User\ReferralController::class, 'requestPayout'])->name('payouts.store');
    });



});

// Video streaming route (protected) - Phase 2
Route::get('/stream/{video}', function (\App\Models\Video $video) {
    // Check if video is preview or if user has access to the course
    $isPreview = $video->is_preview;
    $userLoggedIn = Auth::check();
    $userHasAccess = false;
    
    if ($userLoggedIn) {
        $user = User::find(Auth::id());
        if ($user) {
            // Use the proper method that checks both purchases and subscriptions
            $userHasAccess = $user->hasAccessToCourse($video->course);
        }
    }
    
    if (!$isPreview && !$userHasAccess) {
        abort(403, 'Unauthorized');
    }
    
    // Log video view if user is logged in
    if ($userLoggedIn) {
        $video->userProgress(Auth::id())->updateOrCreate(
            ['user_id' => Auth::id()],
            ['last_watched' => now()]
        );
    }
    
    // Stream video using VideoService
    $videoService = app(\App\Services\VideoService::class);
    return $videoService->streamVideo($video->file_path);
})->middleware('auth')->name('video.stream');


Route::post('/checkout/buy', [App\Http\Controllers\CheckoutController::class, 'buyNow'])
    ->middleware(['auth', 'verified'])
    ->name('checkout.buy');

// Checkout routes
Route::prefix('checkout')->name('checkout.')->middleware('auth', 'verified')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/add', [CheckoutController::class, 'addToCart'])->name('add');
    Route::get('/remove/{cartKey}', [CheckoutController::class, 'removeFromCart'])->name('remove');
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])
        ->middleware('verify.coupon.code')
        ->name('applyCoupon');
    Route::get('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('removeCoupon');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
});

// Payment success routes
Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
// Route::get('/payment/subscription/success', [SubscriptionController::class, 'handleSuccess'])->name('payment.subscription.success');
// Route::get('/payment/order/success', [CheckoutController::class, 'handleSuccess'])->name('payment.order.success');
Route::get('/payment/cancel', [CheckoutController::class, 'cancel'])->name('payment.cancel');

// Add this in web.php
Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');


// Wishlist route for toggling items
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');





    Route::get('/debug-subscription', function() {
    if (!Auth::check()) {
        return "Please log in first";
    }
    
    $user = User::find(Auth::id());
    $activeSubscription = $user->activeSubscription();
    
    if (!$activeSubscription) {
        return "No active subscription found";
    }
    
    $subscriptionPlan = $activeSubscription->subscriptionPlan;
    
    $courses = $subscriptionPlan->courses()->get();
    $products = $subscriptionPlan->digitalProducts()->get();
    
    return [
        'subscription_id' => $activeSubscription->id,
        'plan_id' => $subscriptionPlan->id,
        'plan_name' => $subscriptionPlan->name,
        'is_active' => $activeSubscription->is_active,
        'ends_at' => $activeSubscription->ends_at,
        'courses' => $courses->pluck('id', 'title'),
        'products' => $products->pluck('id', 'name'),
    ];
});


// Referral routes
Route::get('/ref/{code}', [App\Http\Controllers\ReferralController::class, 'processReferral'])->name('referral.process');








// Add new manual payment routes:
Route::get('/payment/upload/{order}', [CheckoutController::class, 'showPaymentReceipt'])->name('payment.upload');
Route::post('/payment/upload/{order}', [CheckoutController::class, 'uploadPaymentReceipt'])->name('payment.upload.store');

// Subscription payment routes
Route::get('/subscription/payment/upload/{subscription}', [SubscriptionController::class, 'showPaymentReceipt'])->name('subscription.payment.upload');
Route::post('/subscription/payment/upload/{subscription}', [SubscriptionController::class, 'uploadPaymentReceipt'])->name('subscription.payment.upload.store');

// Admin payment verification routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Payment verifications
    Route::get('/payment-verifications', [PaymentVerificationController::class, 'index'])->name('payment-verifications.index');
    Route::get('/payment-verifications/order/{order}', [PaymentVerificationController::class, 'showOrder'])->name('payment-verifications.show-order');
    Route::get('/payment-verifications/subscription/{subscription}', [PaymentVerificationController::class, 'showSubscription'])->name('payment-verifications.show-subscription');
    Route::post('/payment-verifications/order/{order}/verify', [PaymentVerificationController::class, 'verifyOrder'])->name('payment-verifications.verify-order');
    Route::post('/payment-verifications/subscription/{subscription}/verify', [PaymentVerificationController::class, 'verifySubscription'])->name('payment-verifications.verify-subscription');
    Route::post('/payment-verifications/order/{order}/reject', [PaymentVerificationController::class, 'rejectOrder'])->name('payment-verifications.reject-order');
    Route::post('/payment-verifications/subscription/{subscription}/reject', [PaymentVerificationController::class, 'rejectSubscription'])->name('payment-verifications.reject-subscription');
    
    // Receipt viewing
    Route::get('/orders/{order}/receipt', [OrderController::class, 'viewReceipt'])->name('orders.receipt');
    Route::get('/subscriptions/{subscription}/receipt', [PaymentVerificationController::class, 'viewSubscriptionReceipt'])->name('subscriptions.receipt');
});

   