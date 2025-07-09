<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use App\Models\Order;
use App\Models\State;
use App\Models\Country;
use App\Models\OrderItem;
use App\Models\PromoCode;
use App\Models\ProductSize;
use App\Models\CustomerCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index(){
        $customer = auth()->guard('customer')->user();
		$settings = DB::table('settings')->first();
        $cart = CustomerCart::where('customer_id', $customer->id)->get();
        $states = State::where('country_id', Country::COUNTRYID_INDIA)->orderBy('name')->get(); //states for India
        $shippingCities = City::where('state_id', $customer->shipping_state_id)->orderBy('name')->get();
        $billingCities = City::where('state_id', $customer->billing_state_id)->orderBy('name')->get();
        if($customer->last_visited_page != 'Payment'){
            $customer->last_visited_page = 'Checkout';
        }
        $customer->save();

        return view('front.checkout', compact('customer', 'cart', 'settings', 'states', 'shippingCities', 'billingCities'));
    }

    public function getCities($state_id){
        $cities = City::where('state_id', $state_id)->orderBy('name')->get();
        
        return response()->json(['cities' => $cities]);
    }

    public function applyPromocode(Request $request){
        $totalAmount = $request->subTotal;
        $promocode = $request->promocode;

        $promocode = PromoCode::where('code', $request->promocode)->first();
        if (!$promocode) {
            return response()->json(['status' => 'error', 'message' => 'This promocode is either invalid or Wrong.']);
        }

        if (!$promocode->isActive()) {
            return response()->json(['status' => 'error', 'message' => 'This promocode is either expired or inactive.']);
        }

        if ($promocode->type == 'percentage') {
            $discount = ($totalAmount * $promocode->discount) / 100;
        } else {
            $discount = $promocode->discount;
        }
        $finalAmount = max(0, $totalAmount - $discount);

        return response()->json([
            'status' => 'success',
            'message' => 'Promocode applied successfully!',
            'discount' => $discount,
            'final_amount' => $finalAmount,
            'promocode_id' => $promocode->id,
        ]);
    }

    public function checkout(Request $request){
        $orderData = [
            'customer_id' => auth()->guard('customer')->user()->id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'billing_street_address' => $request->shipping_street_address,
            'billing_country' => 'India',
            'billing_state' => $request->shipping_state,
            'billing_city' => $request->shipping_city,
            'billing_postal_code' => $request->shipping_postal_code,
            'shipping_street_address' => $request->shipping_street_address,
            'shipping_country' => 'India',
            'shipping_state' => $request->shipping_state,
            'shipping_city' => $request->shipping_city,
            'shipping_postal_code' => $request->shipping_postal_code,
            'payment_method' => 'COD',
            'subtotal' => $request->subtotal,
            'shipping_charge' => $request->shipping_charge,
            'discount_amount' => $request->discount_amount,
            'total_amount' => $request->total_amount,
        ];
        $order = Order::create($orderData);

        $cart = session()->get('cart', []);
        if(count($cart) > 0){
            foreach($cart as $item){
                $productSize = ProductSize::find($item['product_size_id']);

                $itemData = [
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'size_id' => $productSize->size_id,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_amount' => $item['price'] * $item['quantity']
                ];
                OrderItem::create($itemData);
            }
        }

        return redirect()->route('front.index')->with('success', 'Order Placed Successfully.');
    }
	
	public function phonePe2()
    {
        $data = [
            'merchantId' => 'PGTESTPAYUAT',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID123',
            'amount' => 10000,
            'redirectUrl' => route('front.checkout.index'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('front.checkout.submit'),
         
            'paymentInstrument' => [
                'type' => 'PAY_PAGE',
            ],
        ];
    
        $encode = base64_encode(json_encode($data));
    
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;
    
        // Ensure the correct API path is used here.
        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);
        $finalXHeader = $sha256 . '###' . $saltIndex;
    
        $url = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
    
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode(['request' => $encode]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-VERIFY: ' . $finalXHeader,
            ],
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
    
        $response = curl_exec($curl);
		dd($response);
    
        if (curl_errno($curl)) {
            // Handle cURL error
            return response()->json(['error' => curl_error($curl)], 500);
        }
    
        curl_close($curl);
    
        $responseData = json_decode($response, true);
        return response()->json($responseData);
    }
}
