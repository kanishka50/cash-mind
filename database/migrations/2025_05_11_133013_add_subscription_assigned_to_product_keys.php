<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionAssignedToProductKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_keys', function (Blueprint $table) {
            $table->boolean('subscription_assigned')->default(false)->after('used_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_keys', function (Blueprint $table) {
            $table->dropColumn('subscription_assigned');
        });
    }
}