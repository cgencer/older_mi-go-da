<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->unsignedBigInteger('rule_id')->nullable()->index('coupon_codes_rule_id_foreign');
            $table->unsignedBigInteger('coupon_usage_id')->nullable()->index('coupon_codes_coupon_usage_id_foreign');
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
        Schema::dropIfExists('coupon_codes');
    }
}
