<?php

namespace App\Http\Controllers\Front;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = [];
        if(auth()->guard('customer')->check()){
            $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->user()->id)->get();
        }

        return view('front.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        Wishlist::firstOrCreate([
            'customer_id' => auth()->guard('customer')->user()->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Product added to wishlist']);
    }

    public function remove(Request $request)
    {
        Wishlist::where('customer_id', auth()->guard('customer')->user()->id)
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json(['status' => 'success', 'message' => 'Product removed from wishlist']);
    }

    public function removeItem(Request $request)
    {
        Wishlist::find($request->id)->delete();

        return redirect()->back();
    }
}
