<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commission_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('item_type', ['course', 'digital_product']);
            $table->unsignedBigInteger('item_id');
            $table->decimal('rate', 5, 2); // Store as percentage (e.g., 10.00 for 10%)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Create index for faster lookups
            $table->index(['item_type', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_rates');
    }
};