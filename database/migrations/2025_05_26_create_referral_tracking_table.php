<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referral_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id'); // User who shared the link
            $table->string('referral_code', 32)->unique();
            $table->enum('item_type', ['course', 'digital_product']);
            $table->unsignedBigInteger('item_id');
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->timestamps();
            
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['item_type', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_tracking');
    }
};