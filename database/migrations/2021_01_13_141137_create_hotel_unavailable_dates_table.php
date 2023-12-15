<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelUnavailableDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_unavailable_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hotel_id')->nullable()->index('hotel_unavailable_dates_hotel_id_foreign');
            $table->timestamps();
            $table->timestamp('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_unavailable_dates');
    }
}
