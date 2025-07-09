<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Setting;
use App\Models\ProductSize;
use App\Models\CustomerCart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function cart(Request $request)
    {
		$settings = Setting::first();
        
        if($this->isAuth()){
            $customer = $this->authCustomer();
            $sessionId = $customer->id;
        }else{
            $sessionId = $request->session()->getId();
        }

        if($this->isAuth()){
            $cart = CustomerCart::where('customer_id', $this->authCustomer()->id)->get();
            $customer->last_visited_page = 'Customer Cart';
            $customer->save();
        }else{
            $cart = CustomerCart::where('session_id', $sessionId)->get();
        }

        

        return view('front.cart', compact('cart', 'settings'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $productSizeId = $request->size_id;
    
        // Find product
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.']);
        }
    
        // Check for logged-in customer
        $customerId = auth()->guard('customer')->id();
    
        // Use session ID for guest users
        $sessionId = $customerId ? null : $request->session()->getId();
        if (!$sessionId && !$customerId) {
            // Create session ID if not present
            $sessionId = Str::uuid();
            $request->session()->put('session_id', $sessionId);
        }

        // Find existing cart item
        $cartItem = CustomerCart::where(function ($query) use ($customerId, $sessionId) {
            $query->where('customer_id', $customerId)
                  ->orWhere('session_id', $sessionId);
        })
        ->where('product_id', $productId)
        ->where('product_size_id', $productSizeId)
        ->first();

        if ($cartItem != null) {
            // Update existing cart item
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            $itemData = [
                'customer_id' => $customerId,
                'session_id' => $sessionId,
                'product_id' => $productId,
                'product_size_id' => $productSizeId,
                'quantity' => $quantity,
                'price' => $product->net_price,
                //'current_page' => config('constants.CURRENT_PAGES.cart'),
            ];
            CustomerCart::create($itemData);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart!'
        ]);
    }

    public function updateCart(Request $request)
    {
        $quantity = $request->input('quantity');

        $cartItem = CustomerCart::find($request->itemId);
        if(!$cartItem){
            return response()->json(['status' => 'info', 'message' => 'Nothing to update']);
        }

        if($cartItem->product_size_id){
            $productSize = ProductSize::find($cartItem->product_size_id);
            if(isset($productSize->stock) && $productSize->stock < $quantity){
                return response()->json(['status' => 'info', 'message' => 'Only '.$productSize->stock. " quantity left for this product."]);
            }
        }else if($cartItem->product->units_available < $quantity){
            return response()->json(['status' => 'info', 'message' => 'Only '.$cartItem->product->units_available. " quantity left for this product."]);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json(['status' => 'success' , 'message' => 'Cart updated successfully!']);
    }

    public function removeFromCart(Request $request)
    {
        CustomerCart::find($request->item_id)->delete();

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
}
