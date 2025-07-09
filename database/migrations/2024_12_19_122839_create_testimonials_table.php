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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('title')->nullable(); // Title of the review (e.g., "Amazing Fabric")
            $table->text('review')->nullable(); // The actual review text
            $table->string('image')->nullable(); // Optional profile image
            $table->float('rating')->default(0); // Rating out of 5
            $table->boolean('status')->default(1); // Active or inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
