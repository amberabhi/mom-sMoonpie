<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShiprocketApi extends Model
{
    public function __construct(){
        $this->baseUrl = 'https://apiv2.shiprocket.in/v1/external/';
       // $this->token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjU0MDkwNjUsInNvdXJjZSI6InNyLWF1dGgtaW50IiwiZXhwIjoxNzM1MzI1NzM1LCJqdGkiOiJtcWRuN0pvTVROdHozYkQxIiwiaWF0IjoxNzM0NDYxNzM1LCJpc3MiOiJodHRwczovL3NyLWF1dGguc2hpcHJvY2tldC5pbi9hdXRob3JpemUvdXNlciIsIm5iZiI6MTczNDQ2MTczNSwiY2lkIjo1MjA5MDQ3LCJ0YyI6MzYwLCJ2ZXJib3NlIjpmYWxzZSwidmVuZG9yX2lkIjowLCJ2ZW5kb3JfY29kZSI6IiJ9.QKGoOra2awae8GE7AkMs-RGpXEMneUPs3UJ3lKyIe18';
    }

    public function createManualOrder($order){

		try {
			$token = $this->generateToken();
			//echo "Token: " . $token;
		} catch (\Exception $e) {
			echo "Error: " . $e->getMessage();
		}

        $url = $this->baseUrl.'orders/create/adhoc';

        $orderItems = [];
        foreach($order->orderItems as $item){
            $itemData = [
                "name" => $item->product->title,
                "sku" => $item->product->sku,
                "units" => $item->quantity,
                "selling_price" => $item->price,
                "discount" => "",
                "tax" => "",
                "hsn" => "",
            ];
            array_push($orderItems, $itemData);
        }

        $params = [
            "order_id" => $order->id,
            "order_date" => $order->created_at,
            "pickup_location" => "LOCATION1",
            "channel_id" => "",
            "comment" => "Customer Order - $order->id",
            "billing_customer_name" => $order->firstname,
            "billing_last_name" => $order->lastname,
            "billing_address" => $order->billing_street_address,
            "billing_address_2" => "",
            "billing_city" => $order->billing_city,
            "billing_pincode" => $order->billing_postal_code,
            "billing_state" => $order->billing_state,
            "billing_country" => $order->billing_country,
            "billing_email" => $order->email,
            "billing_phone" => $order->contact_number,
            "shipping_is_billing" => false,
            "shipping_customer_name" => $order->firstname,
            "shipping_last_name" => $order->lastname,
            "shipping_address" => $order->shipping_street_address,
            "shipping_address_2" => "",
            "shipping_city" => $order->shipping_city,
            "shipping_pincode" => $order->shipping_postal_code,
            "shipping_country" => $order->shipping_country,
            "shipping_state" => $order->shipping_state,
            "shipping_email" => $order->email,
            "shipping_phone" => $order->contact_number,
            "order_items" => $orderItems,
            "payment_method" => "Prepaid",
            "shipping_charges" => 0,
            "giftwrap_charges" => 0,
            "transaction_charges" => 0,
            "total_discount" => 0,
            "sub_total" => $order->subtotal,
            "length" => 0.5,
            "breadth" => 0.5,
            "height" => 0.5,
            "weight" => 0.5
        ];

		\Log::info('Shipment Create Request', $params);
		
        	$curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        self::insert([
            'type' => 'create_manual_order',
            'url' => $url,
            'request_params' => json_encode($params),
            'response' => $response,
            'created_at' => Carbon::now()
        ]);

        return json_decode($response);
    }
	
	public function generateToken(){
		$url = 'https://apiv2.shiprocket.in/v1/external/auth/login';

		$postData = json_encode([
			'email' => 'makhija.neha107@gmail.com',
			'password' => 'Admin@123',
		]);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Accept: application/json'
		]);

		$response = curl_exec($ch);
		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			curl_close($ch);
			throw new \Exception('Curl Error: ' . $error_msg);
		}

		curl_close($ch);

		$data = json_decode($response, true);

		if ($httpStatus == 200 && isset($data['token'])) {
			return 'Bearer '.$data['token'];
		}

		throw new \Exception('Failed to authenticate with Shiprocket.');
	}
}
