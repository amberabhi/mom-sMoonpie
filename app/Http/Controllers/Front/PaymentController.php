<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use App\Models\Order;
use App\Models\State;
use GuzzleHttp\Client;
use App\Models\Country;
use App\Models\PromoCode;
use App\Models\ProductSize;
use App\Models\CustomerCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //+++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Pay Page
    //+++++++++++++++++++++++++++++++++++++++++
    public function index()
    {
        return view('payments.phonepe')->with('res_data', 'Please Pay & Repond From The Payment Gateway Will Come In This Section');
    }
    //+++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Pay Page
    //+++++++++++++++++++++++++++++++++++++++++
    public function refund()
    {
        return view('refund')->with('res_data', 'Please Refund & Repond From The Payment Gateway Will Come In This Section')->with('res_data_status', 'After Refund Refund Status Will Come');
    }
    //+++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Payment Function - 1st call
    //+++++++++++++++++++++++++++++++++++++++++
    public function payment_init(Request $request)
    {
        $data = $request->all();
		session()->put("checkout_form", $data);
        $phone = $data['contact_number'] ?? '';
		
        $price = $data['total_amount'] ?? 0;
		$subtotal = $data['subtotal'] ?? 0;
		$shipping_charge = $data['shipping_charge'] ?? 0;
		$tax_amount = $data['tax_amount'] ?? 0;
		$discount_amount = $data['discount_amount'] ?? 0;
		
		$total_amount = ($subtotal + $shipping_charge + $tax_amount) - ($discount_amount);
        $amount = $total_amount * 100;

        try {
            //+++++++++++++++++++++++++++++++++++++++++++
            // Creating Payload
            //+++++++++++++++++++++++++++++++++++++++++++
            $normalPayLoad = [
                "merchantId"            => env('PHONEPE_MERCHANT_ID'),
                "merchantTransactionId" => uniqid(),
                "merchantUserId"        => "MUID123",
                "amount"                => $amount,
                "redirectUrl"           => route('front.phonepay.pay-return-url'),
                "redirectMode"          => "POST",
                "callbackUrl"           => route('front.phonepay.pay-callback'),
                "mobileNumber"          => $phone,
                "paymentInstrument"     => [
                    "type" =>  "PAY_PAGE", // "UPI_QR",
                ],
            ];

            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // Encoding the Payload
            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $encode = base64_encode(json_encode($normalPayLoad));

            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // Getting Checksum Value
            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $finalXverify = self::get_checksum_value_request($encode);

            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            // Making Payment Request with Guzzle
            //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $client = new Client();

            $response = $client->post(env('PHONEPE_BASE_URL'), [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $finalXverify,
                ],
                'body' => json_encode(['request' => $encode]),
            ]);

            $response = json_decode($response->getBody(), true);
            $redirectUrl = $response['data']['instrumentResponse']['redirectInfo']['url'] ?? '/';
            
            $customer = $this->authCustomer();
            $customer->last_visited_page = 'Payment';
            $customer->save();

            // Log the response if needed
            Log::info('PhonePe Payment Response:', $response);
            return redirect()->to($redirectUrl);
        } catch (\Exception $e) {
            // Log error and return view with error message
            Log::error('Payment Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong, Please try again after sometime.');
            // return view('payments.phonepe')->with('res_data', $e->getMessage());
        }
    }

   //+++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Payment Callback Function
    //+++++++++++++++++++++++++++++++++++++++++
    public function payment_callback(Request $request) {
        dump('in callback');
        dd($request->all());
    }

    //++++++++++++++++++++++++++++++++++++++++++++++
    //Checksome Genertor Request
    //++++++++++++++++++++++++++++++++++++++++++++++
    private function get_checksum_value_request($payload)
    {
        $saltKey   = env('PHONEPE_SALT_KEY');
        $saltIndex = env('PHONEPE_SALT_INDEX');
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        $string = $payload . '/pg/v1/pay' . $saltKey;

        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        $sha256        = hash('sha256', $string);
        $final_x_vaify = $sha256 . '###' . $saltIndex;
        return $final_x_vaify;
    }
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Checksome Genertor Request
    //++++++++++++++++++++++++++++++++++++++++++++++
    private function get_checksum_value_refund($payload)
    {
        $saltKey   = env('PHONEPE_SALT_KEY');
        $saltIndex = env('PHONEPE_SALT_INDEX');
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        $string = $payload . '/pg/v1/refund' . $saltKey;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        $sha256        = hash('sha256', $string);
        $final_x_vaify = $sha256 . '###' . $saltIndex;
        return $final_x_vaify;
    }
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Normal Payment With Curl Lib
    //++++++++++++++++++++++++++++++++++++++++++++++
    private function payment_with_curl_lib($finalXvaify, $encode)
    {

        $client = new Client();  // Create a Guzzle client

        $url = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
        $finalXverify = 'your_final_xverify_value';  // Replace with your actual value
        $requestData = json_encode(['request' => $encode]);  // Example request payload

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $finalXverify,
                ],
                'body' => $requestData,
            ]);
            $returnData = json_decode($response->getBody(), true);

            // Debug response data if needed
            Log::info('PhonePe Response:', $returnData);

            // Redirect to the payment URL
            return redirect()->to($returnData['data']['instrumentResponse']['redirectInfo']['url']);
        } catch (\Exception $e) {
            Log::error('PhonePe API Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Payment initiation failed'], 500);
        }

        // $response = Curl::to('https://api.phonepe.com/apis/hermes/pg/v1/pay')
        //     ->withHeader('Content-Type:application/json')
        //     ->withHeader('X-VERIFY:' . $finalXvaify)
        //     ->withData(json_encode(['request' => $encode]))
        //     ->enableDebug(public_path('test.txt'))
        //     ->post();
        // $return_data = json_decode($response);
        // dd($return_data);
        // //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // return redirect()->to($return_data->data->instrumentResponse->redirectInfo->url);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    }
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Normal Payment With Curl
    //++++++++++++++++++++++++++++++++++++++++++++++
    private function payment_with_curl($finalXvaify, $encode)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.phonepe.com/apis/hermes/pg/v1/pay');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accept:: application/json',
            'X-VERIFY: ' . $finalXvaify,
        ));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('request' => $encode)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        return redirect()->to($response->data->instrumentResponse->redirectInfo->url);
    }
    //+++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Return Function
    //+++++++++++++++++++++++++++++++++++++++++
    public function payment_return(Request $request)
	{
		$data = $request->all();
		$checkoutData = session()->get('checkout_form', []);

		\Log::error('Payment Return Response: ' . json_encode($data));
        // Begin Transaction
        DB::beginTransaction();
		try {
			if ($request->code == 'PAYMENT_SUCCESS' &&
				!empty($request->merchantId) &&
				!empty($request->transactionId) &&
				!empty($request->providerReferenceId)) {

                $promocodeData = null;
                if(isset($checkoutData['promocode_id'])){
                    $promocode = PromoCode::find($checkoutData['promocode_id']);
                    if($promocode){
                        $promocodeData = json_encode($promocode);
                    }
                }

                $shippingState = State::find($checkoutData['shipping_state_id']);
                $shippingStateName = isset($shippingState->name) ? $shippingState->name : '';

                $shippingCity = City::find($checkoutData['shipping_city_id']);
                $shippingCityName = isset($shippingCity->name) ? $shippingCity->name : '';

                $billingState = State::find($checkoutData['billing_state_id']);
                $billingStateName = isset($billingState->name) ? $billingState->name : '';

                $billingCity = City::find($checkoutData['billing_city_id']);
                $billingCityName = isset($billingCity->name) ? $billingCity->name : '';
				

				$subtotal = $checkoutData['subtotal'] ?? 0;
				$shipping_charge = $checkoutData['shipping_charge'] ?? 0;
				$tax_amount = $checkoutData['tax_amount'] ?? 0;
				$discount_amount = $checkoutData['discount_amount'] ?? 0;
				$total_amount = ($subtotal + $shipping_charge + $tax_amount) - ($discount_amount);

				// Order data from session
				$orderData = [
					'customer_id' => auth()->guard('customer')->user()->id,
					'firstname' => $checkoutData['firstname'] ?? '',
					'lastname' => $checkoutData['lastname'] ?? '',
					'contact_number' => $checkoutData['contact_number'] ?? '',
					'email' => $checkoutData['email'] ?? '',
					'billing_street_address' => $checkoutData['billing_street_address'] ?? '',
					'billing_country' => 'India',
					'billing_country_id' => Country::COUNTRYID_INDIA,
					'billing_state_id' => $checkoutData['billing_state_id'] ?? '',
					'billing_state' => $billingStateName ?? '',
					'billing_city_id' => $checkoutData['billing_city_id'] ?? '',
					'billing_city' => $billingCityName ?? '',
					'billing_postal_code' => $checkoutData['billing_postal_code'] ?? '',
					'shipping_street_address' => $checkoutData['shipping_street_address'] ?? '',
					'shipping_country' => 'India',
					'shipping_country_id' => Country::COUNTRYID_INDIA,
					'shipping_state_id' => $checkoutData['shipping_state_id'] ?? '',
                    'shipping_state' => $shippingStateName ?? '',
					'shipping_city_id' => $checkoutData['shipping_city_id'] ?? '',
                    'shipping_city' => $shippingCityName ?? '',
					'shipping_postal_code' => $checkoutData['shipping_postal_code'] ?? '',
					'payment_method' => 'PhonePe',
					'payment_status' => 'Paid',
					'payment_response' => !empty($data) ? json_encode($data) : NULL,
					'payment_transactionId' => $request->transactionId,
					'subtotal' => $checkoutData['subtotal'] ?? 0,
					'shipping_charge' => $checkoutData['shipping_charge'] ?? 0,
					'tax_amount' => $checkoutData['tax_amount'] ?? 0,
					'tax_amount' => $checkoutData['tax_amount'] ?? 0,
                    'discount_amount' => $checkoutData['discount_amount'] ?? 0,
					'total_amount' => $total_amount ?? 0,
                    'promocode_data' => $promocodeData
				];

				$order = Order::create($orderData);

                $cart = CustomerCart::where('customer_id', $this->authCustomer()->id)->get();
                if(count($cart) > 0){
                	foreach ($cart as $item) {
                        $productSize = ProductSize::find($item->product_size_id);
                        
						$itemData = [
							'order_id' => $order->id,
							'product_id' => $item->product_id,
                            'size_id' => isset($productSize->size_id) ? $productSize->size_id : NULL,
							'price' => $item->price,
							'quantity' => $item->quantity,
							'total_amount' => $item->price * $item->quantity
						];

						$order->orderItems()->create($itemData); // Use relationship method

                        if(isset($productSize)){
                            $updatedStock = $productSize->stock - $item->quantity;
                            $productSize->stock = $updatedStock;
                            $productSize->save();
                        }
                    }
                }
                // empty cart
                CustomerCart::where('customer_id',$this->authCustomer()->id)->delete();

                DB::commit();
                
				return redirect()->route('front.my-account.orders')->with('success', 'Order Placed Successfully.');

			} else {
				$msg = 'Something went wrong, please try after sometime.';
				if ($request->code == 'PAYMENT_PENDING') {
					$msg = 'Your last transaction was failed. Please retry the payment.';
				}

				return redirect()->route('front.cart')->with('info', $msg);
			}

		} catch (\Exception $e) {
			$msg = 'Something went wrong, please try after sometime.';
			\Log::error('Payment Return Error: ' . $e->getMessage());
			return redirect()->route('front.cart')->with('error', $msg);
		}
	}


    
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Checksome Genertor Request
    //++++++++++++++++++++++++++++++++++++++++++++++
    private function get_checksum_value_respond($merchantId, $transactionId)
    {
       $saltKey   = env('PHONEPE_SALT_KEY');
        $saltIndex = env('PHONEPE_SALT_INDEX');
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        $string = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $transactionId . $saltKey) . '###' . $saltIndex;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
        return $string;
    }
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Refund Function
    //++++++++++++++++++++++++++++++++++++++++++++++
    public function payment_refund(Request $request)
	{	
		try {
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			$saltKey   = env('PHONEPE_SALT_KEY');
			$saltIndex = env('PHONEPE_SALT_INDEX');
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			$tid = $request->refund_tnx_id;
			$tid = "673f7748d6485";  // example transaction ID, replace with the actual one from the request
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			$payload = [
				'merchantId'            => env('PHONEPE_MERCHANT_ID'),
				'merchantUserId'        => 'MUID123',
				'merchantTransactionId' => 'REFUND-'.$tid,
				'originalTransactionId' => $tid,
				'amount'                => 100, // Replace with actual refund amount if needed
				'callbackUrl'           => route('front.pay-refund-callback'), // Callback URL for your app
			];
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// Make Data Encoded
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$encode = base64_encode(json_encode($payload));
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// Getting The Checksum Value
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$finalXvaify = self::get_checksum_value_refund($encode);

			// cURL request for Refund API
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://api.phonepe.com/apis/hermes/pg/v1/refund');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
				'X-VERIFY: ' . $finalXvaify
			]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['request' => $encode]));

			// Execute cURL request
			$response = curl_exec($ch);

			// Check for errors in the cURL request
			if (curl_errno($ch)) {
				\Log::error('cURL Error: ' . curl_error($ch));
				throw new \Exception('cURL request for refund failed: ' . curl_error($ch));
			}

			// Close cURL session
			curl_close($ch);

			// Decode the response
			$rData = json_decode($response, true); // Decoding the response as an associative array

			// Log the response data for debugging
			\Log::info('Refund API Response: ', $rData);

			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// cURL request for Status Check (after refund)
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$finalXvaifyStatus = hash('sha256', '/pg/v1/status/' . 'MOMSMONLINE' . '/' . $tid . $saltKey) . '###' . $saltIndex;

			// Initialize cURL session for status request
			$statusCh = curl_init();
			curl_setopt($statusCh, CURLOPT_URL, 'https://api.phonepe.com/apis/hermes/merchant-simulator/pg/v1/status/' . 'MOMSMONLINE' . '/' . $tid);
			curl_setopt($statusCh, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($statusCh, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
				'accept: application/json',
				'X-VERIFY: ' . $finalXvaifyStatus,
				'X-MERCHANT-ID: ' . $tid
			]);

			$responsestatus = curl_exec($statusCh);

			// Check for errors in the cURL request
			if (curl_errno($statusCh)) {
				\Log::error('cURL Error: ' . curl_error($statusCh));
				throw new \Exception('cURL request for status failed: ' . curl_error($statusCh));
			}

			// Close cURL session for status check
			curl_close($statusCh);

			// Decode the status response
			$statusData = json_decode($responsestatus, true);

			// Log the status data for debugging
			\Log::info('Refund Status API Response: ', $statusData);

			// Return the view with the response data
			return view('front.refund')
				->with('res_data', $rData) // Refund API response
				->with('res_data_status', $statusData); // Status API response

		} catch (\Exception $e) {
			// Log any exceptions
			\Log::error('Error in refund process: ' . $e->getMessage());

			// Return view with error message
			return view('front.refund')->with('res_data', 'Error: ' . $e->getMessage());
		}
	}

    //++++++++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Refund Function
    //++++++++++++++++++++++++++++++++++++++++++++++
    public function payment_refund_callback(Request $request)
    {
		 dd($request->all());
        try {
            dd($request->all());
        } catch (\Exception $e) {
            return view('refund')->with('res_data', $e->getMessage());
        }
    }
}
