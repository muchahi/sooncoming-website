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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique discount code
            $table->decimal('discount_percentage', 5, 2); // Discount percentage (e.g., 10.00)
            $table->date('start_date'); // Date when the discount becomes active
            $table->date('end_date'); // Date when the discount expires
            $table->boolean('active')->default(true); // Whether the discount is active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
