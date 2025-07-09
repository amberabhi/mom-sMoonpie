<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ShiprocketApi;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index(){
        $orders = Order::orderByDesc('id')->get();

        return view('admin.orders.index', compact('orders'));
    } 

    public function edit(Order $order){
 
        return view('admin.orders.edit', compact('order'));
    } 

    public function update(Request $request, $id){
        Order::where('id', $id)->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function createShipment($orderId){
        $order = Order::findOrFail($orderId);

        $shipment = (new ShiprocketApi)->createManualOrder($order);

        $shipmentData = [
            'shiprocket_order_id' => isset($shipment->order_id) ? $shipment->order_id : '',
            'shipment_status' => isset($shipment->status) ? $shipment->status : '',
            'shipment_response' => json_encode($shipment),
        ];
        Order::find($orderId)->update($shipmentData);

        if($shipment && $shipment->status_code == 1){
            return redirect()->route('admin.orders.index')->with('success', 'Order shipment created successfully.'); 
        
        }else if(isset($shipment->message)){
            return redirect()->route('admin.orders.index')->with('error', 'Shipment Error : '.$shipment->message); 
        
        }else{
            return redirect()->route('admin.orders.index')->with('error', 'Shipment Error Occurred.'); 
        }
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Refund Function
    //++++++++++++++++++++++++++++++++++++++++++++++
	public function refundPayment($orderId){
		$order = Order::findOrFail($orderId);
		$paymentResponse = !empty($order->payment_response) ? json_decode($order->payment_response,true) : [];
		if(empty($paymentResponse)){
			return redirect()->back()->with('error', 'Something went wrong with the payment!');
		}
		$tid = $paymentResponse['transactionId'] ?? ''; // example transaction ID, replace with the actual one from the request
		$amount = (Integer)$paymentResponse['amount'] ?? 0;

		try {
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			$saltKey   = env('PHONEPE_SALT_KEY');
			$saltIndex = env('PHONEPE_SALT_INDEX');
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++
			$payload = [
				'merchantId'            => env('PHONEPE_MERCHANT_ID'),
				'merchantUserId'        => 'MUID123',
				'originalTransactionId' => $tid,
				'merchantTransactionId' => strrev($tid),
				'amount'                => $amount, // Replace with actual refund amount if needed
				'callbackUrl'           => route('admin.refund-callback'), // Callback URL for your app
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
			/*
			if(isset($rData['success']) && $rData['success'] == false && $rData['code'] == 'DUPLICATE_TXN_REQUEST'){
				return redirect()->back()->with('error', $rData['message']);
			}else if(isset($rData['success']) && $rData['success'] == false){
				return redirect()->back()->with('error', $rData['message']);
			}else if(isset($rData['success']) && $rData['success'] == false && $rData['code'] == 'PAYMENT_ERROR'){
				return redirect()->back()->with('error', $rData['message']);
			}else if(isset($rData['success']) && $rData['success'] == true && $rData['code'] == 'PAYMENT_PENDING'){
				return redirect()->back()->with('error', $rData['message']);
			}
			*/

			// Log the response data for debugging
			\Log::info('Refund API Response:: '. $response);

			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// cURL request for Status Check (after refund)
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			$merchantId = env('PHONEPE_MERCHANT_ID'); // Fetch merchant ID from environment file
			$saltKey = env('PHONEPE_SALT_KEY');      // Fetch salt key
			$saltIndex = env('PHONEPE_SALT_INDEX'); // Fetch salt index

			// Generate the checksum for the status request
			$finalXvaifyStatus = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $tid . $saltKey) . '###' . $saltIndex;

			// Initialize cURL session for status request
			$statusCh = curl_init();
			curl_setopt($statusCh, CURLOPT_URL, 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $merchantId . '/' . $tid);
			curl_setopt($statusCh, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($statusCh, CURLOPT_HTTPHEADER, [
				'Content-Type: application/json',
				'accept: application/json',
				'X-VERIFY: ' . $finalXvaifyStatus,
				'X-MERCHANT-ID: ' . $merchantId
			]);

			// Execute cURL request
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

			// Log the status data
			\Log::info('Status API Response:', $statusData);

			// Debug or handle the response
			if($statusData['success'] == true && $statusData['code'] == 'PAYMENT_SUCCESS'){
				$order->refund_response = json_encode($statusData);
				$order->refund_message = $statusData['message'];
				$order->refund_status = 'refunded';
				$order->payment_status = 'refunded';
				$order->save();
				// Return the view with the response data
				return redirect()->back()->with('success', $statusData['message']);
			}else{
				return redirect()->back()->with('error', $statusData['message']);
			}

		} catch (\Exception $e) {
			// Log any exceptions
			\Log::error('Error in refund process: ' . $e->getMessage());
			// Return view with error message
			return redirect()->back()->with('error', 'Error:: '.$e->getMessage());
		}
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++
    //Phone Pay Refund Function
    //++++++++++++++++++++++++++++++++++++++++++++++
    public function refund_callback(Request $request)
	{
		try {
			// Log the incoming callback data for debugging
			\Log::info('Refund Callback Data:', $request->all());

			// Validate the incoming request data
			$data = $request->validate([
				'transactionId' => 'required|string',
				'merchantTransactionId' => 'required|string',
				'amount' => 'required|integer',
				'status' => 'required|string', // Example: "SUCCESS" or "FAILED"
				'message' => 'nullable|string',
			]);

			// Process the refund callback
			$transactionId = $data['transactionId'];
			$merchantTransactionId = $data['merchantTransactionId'];
			$status = $data['status'];
			$message = $data['message'] ?? 'No message provided';

			// Log the status for monitoring
			if ($status === 'SUCCESS') {
				\Log::info("Refund Successful for Transaction ID: $transactionId");
			} else {
				\Log::warning("Refund Failed for Transaction ID: $transactionId. Message: $message");
			}

			// Perform any additional processing, e.g., updating the database
			$order = Order::where('payment_transactionId', $transactionId)->first();
			if ($order) {
				$order->refund_status = $status === 'SUCCESS' ? 'refunded' : 'failed';
				$order->refund_message = $message;
				$order->save();
			}

			// Respond to the callback request (acknowledgment)
			return response()->json(['status' => 'success', 'message' => 'Callback processed successfully'], 200);

		} catch (\Exception $e) {
			// Log the error for debugging
			\Log::error('Error in Refund Callback: ' . $e->getMessage());

			// Respond with an error status
			return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
		}
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
}