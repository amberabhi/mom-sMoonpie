<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\MarqueeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsPagesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\ShiprocketWebhookController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\CustomerCartsController;
use App\Http\Controllers\Admin\ProductCategoryController;

Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware('auth');

Route::prefix('admin')->as('admin.')->middleware('auth')->group(function () {
    
    Route::resources([
        'sizes'=> SizeController::class,
        'orders'=> OrdersController::class,
        'banners'=>BannersController::class,
        'settings'=>SettingsController::class,
        'products'=> ProductsController::class,
        'cms-pages'=> CmsPagesController::class,
        'customers'=> CustomersController::class,
        'categories'=> CategoryController::class,
        'promocodes'=> PromoCodeController::class,
        'marquee-items' => MarqueeController::class,
        'testimonials'=> TestimonialsController::class,
        'customer-carts'=> CustomerCartsController::class,
        'product-categories'=> ProductCategoryController::class,
    ]);

    //Product Routes
    Route::prefix('products')->name('products.')->group(function() {
        Route::get('remove-image/{imageId}', [ProductsController::class, 'removeImage'])->name('remove-image');
        Route::get('set-default-image/{imageId}', [ProductsController::class, 'setDefaultImage'])->name('set-default-image');
        Route::get('inventory/{id}', [ProductsController::class, 'viewInventory'])->name('inventory');
        Route::post('store-inventory', [ProductsController::class, 'storeInventory'])->name('store-inventory');
    });

    //Order Routes
    Route::prefix('orders')->name('orders.')->group(function() {
        Route::get('create-shipment/{id}', [OrdersController::class, 'createShipment'])->name('create-shipment');
		Route::get('refund-payment/{id}', [OrdersController::class, 'refundPayment'])->name('refund-payment');
    });

    //Profile Routes
    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/', [AdminController::class, 'profile'])->name('index');
        Route::post('update', [AdminController::class, 'profileUpdate'])->name('update');
    });
	
	// Payment Routes
	Route::post('refund-callback', [OrdersController::class, 'refund_callback'])->name('refund-callback');

    Route::prefix('customers')->name('customers.')->group(function() {
        Route::get('get-cities/{state_id}', [CustomersController::class, 'getCities'])->name('get-cities');
    });
    
});

//Shiprocket Webhook
Route::post('/webhook/delivery-status', [ShiprocketWebhookController::class, 'handleWebhook']);
//Route::post('shiprocket-webhooks', [ShiprocketWebhookController::class, 'handleWebhook']);

