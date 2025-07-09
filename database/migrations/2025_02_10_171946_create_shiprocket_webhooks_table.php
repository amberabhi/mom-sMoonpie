<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shiprocket_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('awb')->unique();
            $table->string('order_id');
            $table->string('status');
            $table->string('courier_name')->nullable();
            $table->timestamp('last_updated');
            $table->json('scan_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shiprocket_webhooks');
    }
};
