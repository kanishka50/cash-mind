<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commission_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Referrer
            $table->unsignedBigInteger('referred_user_id'); // New user who registered
            $table->string('referral_code', 32);
            $table->unsignedBigInteger('order_id');
            $table->enum('item_type', ['course', 'digital_product']);
            $table->unsignedBigInteger('item_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('rate_used', 5, 2); // The rate that was used at time of conversion
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referred_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_earnings');
    }
};