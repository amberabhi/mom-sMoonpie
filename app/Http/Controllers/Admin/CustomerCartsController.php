<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\CustomerCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerCartsController extends Controller
{
    public function index(){
        $customerCarts = CustomerCart::with('customer')->latest()
                        ->get()
                        ->groupBy('customer_id');

        return view('admin.customer-carts.index', compact('customerCarts'));
    } 

    public function edit($customerId){
        $customer = Customer::find($customerId);
        $cartItems = CustomerCart::where('customer_id', $customerId)->orderByDesc('id')->get();
        
        return view('admin.customer-carts.edit', compact('customer', 'cartItems'));
    }
}
 