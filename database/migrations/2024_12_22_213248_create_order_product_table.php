<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // foreign key to orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // foreign key to products
            $table->integer('quantity'); // quantity of products
            $table->decimal('price', 10, 2); // price at the time of the order
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
