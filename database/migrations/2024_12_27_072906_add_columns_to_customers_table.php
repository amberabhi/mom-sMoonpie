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
        Schema::table('customers', function (Blueprint $table) {
            $table->text('shipping_street_address')->nullable()->after('plain_password');
            $table->unsignedBigInteger('shipping_state_id')->nullable()->after('shipping_street_address');
            $table->unsignedBigInteger('shipping_city_id')->nullable()->after('shipping_state_id');
            $table->string('shipping_postal_code')->nullable()->after('shipping_city_id');
            $table->unsignedBigInteger('shipping_country_id')->nullable()->after('shipping_postal_code');

            $table->text('billing_street_address')->nullable()->after('shipping_country_id');
            $table->unsignedBigInteger('billing_state_id')->nullable()->after('billing_street_address');
            $table->unsignedBigInteger('billing_city_id')->nullable()->after('billing_state_id');
            $table->string('billing_postal_code')->nullable()->after('billing_city_id');
            $table->unsignedBigInteger('billing_country_id')->nullable()->after('billing_postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_street_address',
                'shipping_state_id',
                'shipping_city_id',
                'shipping_postal_code',
                'shipping_country_id',
                'billing_street_address',
                'billing_state_id',
                'billing_city_id',
                'billing_postal_code',
                'billing_country_id'
            ]);
        });
    }
};
