<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('reservations_customer_id_foreign');
            $table->dropForeign('reservations_hotel_id_foreign');
        });
    }
}
