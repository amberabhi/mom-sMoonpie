<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Models\ShiprocketWebhook;
use Illuminate\Support\Facades\Log;

class UpdateShipmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:shipment-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch shiprocket shipment data and update order status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('🚀 Running shipment status update cron job...');

        // Fetch all unprocessed shipments
        $shipments = ShiprocketWebhook::all();

        if ($shipments->isEmpty()) {
            Log::info('✅ No new shipments to process.');
            return;
        }
        
        foreach ($shipments as $shipment) {
            // dd($shipment);
            // Find the corresponding order
            $order = Order::where('shiprocket_order_id', $shipment->order_id)->first();

            if (!$order) {
                Log::error("❌ No order found for Shiprocket order_id: " . $shipment->order_id);
                continue;
            }

            // Update order status
            $order->shipment_status = $shipment->status;
            $order->trackings = $shipment->scan_details;
            $order->save();

            Log::info("✅ Order ID {$order->id} updated with shipment status: {$shipment->status}");
        }

        return 0;
    }
}
