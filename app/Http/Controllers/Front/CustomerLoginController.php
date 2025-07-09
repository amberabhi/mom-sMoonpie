<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerLoginController extends Controller
{
    public function index(){
        return view('front.auth.login');
    }

    public function login(Request $request){
        $sessionId = $request->session()->getId();
        
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'string', 'max:255'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
           
        if (Auth::guard('customer')->attempt($credentials)) {
            $customer = Auth::guard('customer')->user();

            if($customer->status != 1){
                return back()->withErrors([
                    'email' => 'Your account is deactivated. Contact adminstrator for more details.',
                ])->onlyInput('email');
            }

            $this->transfercartToCustomer($sessionId, $customer->id);
            $request->session()->regenerate();

            return redirect()->route('front.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.customer-login');
    }

    /**
     * Transfer cart from session to the logged in customer.
     */
    private function transfercartToCustomer(string $sessionId, int $customerid): void
    {
        $guestCartItems = CustomerCart::where('session_id', $sessionId)->get();

        foreach ($guestCartItems as $item) {
            $existingCartItem = CustomerCart::where('customer_id', $customerid)
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingCartItem) {
                // Merge quantities if the product already exists in the user's cart
                $existingCartItem->quantity += $item->quantity;
                $existingCartItem->save();
                $item->delete(); // Remove the guest cart item
            } else {
                // Assign the cart item to the user
                $item->update([
                    'customer_id' => $customerid,
                    'session_id' => null,
                ]);
            }
        }
    }
}
