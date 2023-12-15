<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_country_id_foreign');
            $table->dropForeign('payments_customer_id_foreign');
            $table->dropForeign('payments_reservation_id_foreign');
        });
    }
}
