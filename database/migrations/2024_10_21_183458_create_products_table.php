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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('brand');
            $table->string('title');
            $table->string('product_type');
            $table->string('color')->nullable();
            $table->string('age_group')->nullable();
            $table->string('lb')->nullable(); // LxB or LxBxH
            $table->string('lbh')->nullable(); // LxB or LxBxH
            $table->float('weight')->nullable();
            $table->string('quantity')->nullable(); // e.g., Single, 5 Combos
            $table->integer('units_available')->default(0);
            $table->decimal('mrp', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('net_price', 8, 2);
            $table->text('description')->nullable();
            $table->string('material')->nullable();
            $table->string('customer_care')->nullable();
            $table->string('ref_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
