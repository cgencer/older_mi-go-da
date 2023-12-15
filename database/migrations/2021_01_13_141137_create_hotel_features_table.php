<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hotel_id')->index('hotel_features_hotel_id_foreign');
            $table->unsignedBigInteger('feature_id')->index('hotel_features_feature_id_foreign');
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
        Schema::dropIfExists('hotel_features');
    }
}
