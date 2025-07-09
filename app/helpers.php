<?php

use App\Models\Category;
use App\Models\CustomerCart;

if (!function_exists('getNavCategories')) {
    function getNavCategories() {
        return Category::where('is_active', 1)->get();
    }
}

if (!function_exists('getCartItemsCount')) {
    function getCartItemsCount() {
        return App\Models\CustomerCart::where('customer_id', auth()->guard('customer')->id())->count();
    }
}
