<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHotelUnavailableDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_unavailable_dates', function (Blueprint $table) {
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
        Schema::table('hotel_unavailable_dates', function (Blueprint $table) {
            $table->dropForeign('hotel_unavailable_dates_hotel_id_foreign');
        });
    }
}
