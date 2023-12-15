<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_codes', function (Blueprint $table) {
            $table->foreign('coupon_usage_id')->references('id')->on('coupon_usages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('rule_id')->references('id')->on('coupon_rules')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_codes', function (Blueprint $table) {
            $table->dropForeign('coupon_codes_coupon_usage_id_foreign');
            $table->dropForeign('coupon_codes_rule_id_foreign');
        });
    }
}
