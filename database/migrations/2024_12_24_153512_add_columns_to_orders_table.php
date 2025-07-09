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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('billing_country_id')->nullable()->after('billing_street_address');
            $table->integer('billing_state_id')->nullable()->after('billing_country');
            $table->integer('billing_city_id')->nullable()->after('billing_state');

            $table->integer('shipping_country_id')->nullable()->after('shipping_street_address');
            $table->integer('shipping_state_id')->nullable()->after('shipping_country');
            $table->integer('shipping_city_id')->nullable()->after('shipping_state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
