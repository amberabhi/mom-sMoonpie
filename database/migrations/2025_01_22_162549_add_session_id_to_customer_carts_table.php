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
        Schema::table('customer_carts', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('id');
            $table->string('current_page')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_carts', function (Blueprint $table) {
            $table->dropColumn('session_id');
            $table->dropColumn('current_page');
        });
    }
};
