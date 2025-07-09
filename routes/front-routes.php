<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CMSController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\Front\CustomerLoginController;
use App\Http\Controllers\Front\CustomerRegisterController;
use Illuminate\Support\Facades\Artisan;

use App\Http\Middleware\VerifyCsrfToken;

Route::get('/artisan-clear', function () {
    // Clear and cache configuration
    Artisan::call('optimize:clear');
    return 'Configuration, cache, and routes cleared!';
}); // Use proper middleware to secure this route.

Route::as('front.')->group(function () {
	
	// Route::get('/payment', [CheckoutController::class, 'phonePe2'])->name('payment');
	
	//++++++++++++++++++++++++++++++++++++++++++++++
	//The Payment Route For The Product
	//+++++++++++++++++++++++++++++++++++++++++++++
	Route::post('payment', [PaymentController::class, 'payment_init'])->name('phonepay.pay'); // 1st call
    Route::post('pay-return', [PaymentController::class, 'payment_return'])->name('phonepay.pay-return-url'); // 2nd call
	Route::post('pay-callback', [PaymentController::class, 'payment_callback'])->name('phonepay.pay-callback');
	Route::get('pay-refund-view', [PaymentController::class, 'refund']);
	Route::get('pay-refund', [PaymentController::class, 'payment_refund']);
	
	
	// Route::post('pay-callback', [PaymentController::class, 'payment_callback'])->name('pay-callback-url');
	Route::post('pay-refund-callback', [PaymentController::class, 'payment_refund_callback'])->name('pay-refund-callback');

    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('products/{category?}', [IndexController::class, 'productList'])->name('product-list');
    Route::get('product-details/{product}', [IndexController::class, 'productDetails'])->name('product-details');
    Route::post('product-details/inventory', [IndexController::class, 'productInventory'])->name('product-inventory');

    //customer login
    Route::get('customer-login', [CustomerLoginController::class, 'index'])->name('customer-login');
    Route::post('customer-login', [CustomerLoginController::class, 'login'])->name('customer-login');
    Route::post('customer-logout', [CustomerLoginController::class, 'logout'])->name('customer-logout');

    //customer register
    Route::get('customer-register', [CustomerRegisterController::class, 'index'])->name('customer-register');
    Route::post('customer-register', [CustomerRegisterController::class, 'register'])->name('customer-register');

    // add to cart routes
    Route::get('shopping-cart', [CartController::class, 'cart'])->name('cart');
    Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove-item', [CartController::class, 'removeFromCart'])->name('cart.remove-item');

    //wishlists
    Route::prefix('wishlists')->name('wishlists.')->group(function() {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('add', [WishlistController::class, 'add'])->name('add');
        Route::post('remove', [WishlistController::class, 'remove'])->name('remove');
        Route::post('remove-item', [WishlistController::class, 'removeItem'])->name('remove-item');
    });

    // content pages
	Route::get('privacy-policy', [CMSController::class, 'privacyPolicy'])->name('privacy-policy');
	Route::get('returns-policy', [CMSController::class, 'returnsPolicy'])->name('returns-policy');
	Route::get('contact-us', [CMSController::class, 'contactUs'])->name('contact-us');
	Route::get('terms-and-conditions', [CMSController::class, 'termsAndConditions'])->name('terms-and-conditions');
	Route::get('shipping-policy', [CMSController::class, 'shippingPolicy'])->name('shipping-policy');
	Route::get('about-us', [CMSController::class, 'aboutUs'])->name('about-us');

    //Middleware
    Route::middleware(['customer.auth'])->group(function () {

        //my-account
        Route::name('my-account.')->group(function() {
            Route::get('profile', [MyAccountController::class, 'profile'])->name('profile');
            Route::post('profile-update', [MyAccountController::class, 'profileUpdate'])->name('profile-update');
            Route::get('my-account/get-cities/{state_id}', [MyAccountController::class, 'getCities'])->name('get-cities');

            Route::get('change-password', [MyAccountController::class, 'changePassword'])->name('change-password');
            Route::post('update-password', [MyAccountController::class, 'updatePassword'])->name('update-password');

            Route::get('orders', [MyAccountController::class, 'orders'])->name('orders');
            Route::get('order-invoice/{orderId}', [MyAccountController::class, 'orderInvoice'])->name('order-invoice');
            Route::get('order-tracking/{orderId}', [MyAccountController::class, 'orderTracking'])->name('order-tracking');
        });

        //checkout
        Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout.submit');
        Route::get('get-cities/{state_id}', [CheckoutController::class, 'getCities'])->name('checkout.get-cities');

        Route::post('apply-promocode', [CheckoutController::class, 'applyPromocode'])->name('checkout.apply-promocode');
    });
});


