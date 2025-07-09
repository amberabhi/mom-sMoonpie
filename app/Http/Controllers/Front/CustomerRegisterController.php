<?php

namespace App\Http\Controllers\Front;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerRegisterController extends Controller
{
    public function index(){
        return view('front.auth.register');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'contact_number' => 'required|numeric|digits:10',
            'password' => 'required|string|min:4|confirmed',
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
            'plain_password' => $request->password,
            'password' => Hash::make($request->password),
        ];

        $customer = Customer::create($customerData);
        if($customer){
            return redirect()->route('front.customer-login')->with('success', 'Registration succesfull. Please login here.');
        }
        
        return redirect()->route('front.customer-login')->with('success', 'Registration failed.');
    }
}
