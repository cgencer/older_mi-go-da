<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->unsignedBigInteger('rule_id')->nullable()->index('coupon_usages_rule_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable()->index('coupon_usages_customer_id_foreign');
            $table->unsignedBigInteger('reservation_id')->nullable()->index('coupon_usages_reservation_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_usages');
    }
}
