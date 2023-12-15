<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCouponUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->dropForeign('coupon_usages_customer_id_foreign');
            $table->dropForeign('coupon_usages_reservation_id_foreign');
            $table->dropForeign('coupon_usages_rule_id_foreign');
        });
    }
}
