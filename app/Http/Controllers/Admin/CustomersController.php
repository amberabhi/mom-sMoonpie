<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function index(){
        $customers = Customer::orderByDesc('id')->get();

        return view('admin.customers.index', compact('customers'));
    } 

    public function edit(Customer $customer){
        $states = State::where('country_id', Country::COUNTRYID_INDIA)->orderBy('name')->get(); //states for India
        $shippingCities = City::where('state_id', $customer->shipping_state_id)->orderBy('name')->get();
        $billingCities = City::where('state_id', $customer->billing_state_id)->orderBy('name')->get();

        return view('admin.customers.edit', compact('customer', 'states', 'shippingCities', 'billingCities'));
    } 

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact_number' => 'required|numeric|digits:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customerData = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'status' => $request->status,

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

        $customer = Customer::find($id)->update($customerData);
        if($customer){
            return redirect()->route('admin.customers.index')->with('success', 'Customer Updated successfully.');
        }
        
        return redirect()->route('admin.customers.index')->with('error', 'Something Went Wrong');
    }

    public function getCities($state_id){
        $cities = City::where('state_id', $state_id)->orderBy('name')->get();
        
        return response()->json(['cities' => $cities]);
    }
}
