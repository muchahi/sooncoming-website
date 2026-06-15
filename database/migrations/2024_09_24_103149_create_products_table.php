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
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('stock');
            $table->json('images');
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_id')->constrained('product_types')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->string('location_id')->default('n/a');
            $table->string('status')->default('normal');
            $table->string('discount_percentage')->default(0);
            $table->string('reviews')->default(0);
            $table->string(column: 'stars')->default(0);
            $table->string('delivery_days')->default(1);
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
