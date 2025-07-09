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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('material');
            $table->integer('is_new_collection')->default(0)->after('status');
            $table->integer('is_trending')->default(0)->after('is_new_collection');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('is_new_collection');
            $table->dropColumn('is_trending');
        });
    }
};
