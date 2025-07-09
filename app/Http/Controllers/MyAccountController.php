<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\State;
use App\Models\Country;

use App\Models\Customer;
use App\Models\ShiprocketWebhook;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function profile(){
        $customer = Auth::guard('customer')->user();
        $states = State::where('country_id', Country::COUNTRYID_INDIA)->orderBy('name')->get(); //states for India
        $shippingCities = City::where('state_id', $customer->shipping_state_id)->orderBy('name')->get();
        $billingCities = City::where('state_id', $customer->billing_state_id)->orderBy('name')->get();

        return view('front.my-account.profile', compact('customer', 'states', 'shippingCities', 'billingCities'));
    }

    public function profileUpdate(Request $request)
    {
        $customerId = Auth::guard('customer')->user()->id;
        $data = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),

            'shipping_street_address' => $request->input('shipping_street_address'),
            'shipping_state_id' => $request->input('shipping_state_id'),
            'shipping_city_id' => $request->input('shipping_city_id'),
            'shipping_postal_code' => $request->input('shipping_postal_code'),
            'shipping_country_id' => Country::COUNTRYID_INDIA,

            'billing_street_address' => $request->input('billing_street_address'),
            'billing_state_id' => $request->input('billing_state_id'),
            'billing_city_id' => $request->input('billing_city_id'),
            'billing_postal_code' => $request->input('billing_postal_code'),
            'billing_country_id' => Country::COUNTRYID_INDIA,
        ];

        Customer::where('id', $customerId)->update($data);

        return redirect()->back()->with('success', 'Profile Updated Successfully.');
    }

    public function orders(){
        $orders = Order::where('customer_id', auth()->guard('customer')->id())->orderByDesc('id')->get();

        return view('front.my-account.orders', compact('orders'));
    }

    public function orderInvoice($orderId){
        $order = Order::where('customer_id', auth()->guard('customer')->id())->findOrFail($orderId);

        $pdf = PDF::loadView('front.my-account.order-invoice', compact('order'));
        return $pdf->stream('order-' . $orderId . '.pdf');

        return view('front.my-account.order-invoice', compact('order'));
    }

    public function changePassword(){
        return view('front.my-account.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:4|confirmed', 
        ]);

        $user = Auth::guard('customer')->user();
        $user->plain_password = $request->password;
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function getCities($state_id){
        $cities = City::where('state_id', $state_id)->orderBy('name')->get();
        
        return response()->json(['cities' => $cities]);
    }

    public function orderTracking($orderId){
        $trackingDetails = ShiprocketWebhook::where('order_id',$orderId)->first();
        return view('front.my-account.order-tracking',compact('trackingDetails'));
    }
}
