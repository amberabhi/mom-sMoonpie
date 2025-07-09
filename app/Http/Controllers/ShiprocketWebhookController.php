<?php

namespace App\Http\Controllers;

use App\Models\ShiprocketWebhook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ShiprocketWebhookController extends Controller
{
    public function handleWebhook(Request $request){

        // Expected API key (from .env for security)
        $expectedApiKey = env('SHR_WH_API_KEY', 'c0ca59cc-9516-4f6e-bf70-7b6cfcc0c921');

        // Get API key from the request header
        $apiKey = $request->header('x-api-key');

        // Check if the provided API key is correct
        if (!$apiKey || $apiKey !== $expectedApiKey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        $data = $request->all();
        Log::info('Shiprocket Webhook Payload:', $data);

        try {
            $validatedData = $request->validate([
                'awb' => 'required',
                'current_status' => 'required|string',
                'order_id' => 'required|string',
                'current_timestamp' => 'required|date',
                'shipment_status' => 'required|string',
                'shipment_status_id' => 'required|integer',
                'courier_name' => 'nullable|string',
                'scans' => 'nullable|array',
            ]);

            ShiprocketWebhook::updateOrCreate(
                ['awb' => $validatedData['awb']], // Find shipment by AWB
                [
                    'order_id' => $validatedData['order_id'],
                    'status' => $validatedData['shipment_status'],
                    'courier_name' => $validatedData['courier_name'] ?? 'Unknown',
                    'last_updated' => $validatedData['current_timestamp'],
                    'scan_details' => json_encode($validatedData['scans']),
                ]
            );

            return response()->json(['message' => 'Webhook processed successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
