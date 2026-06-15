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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->string('preferred_language')->default('en');
            $table->string('preferred_currency')->default('USD');
            $table->integer('points')->default(0);
            $table->string('preferred_timezone')->default('UTC');
            $table->string('preferred_theme')->default('light');
            $table->json('shipping_methods')->nullable(); // To store multiple shipping methods
            $table->json('payment_methods')->nullable(); // To store multiple payment methods
            $table->string('preferred_payment_method')->nullable(); // Default payment method
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('user_type')->default('user');
            $table->string('email')->nullable();
            $table->string(column: 'name')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
