<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHotelFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_features', function (Blueprint $table) {
            $table->foreign('feature_id')->references('id')->on('features')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('hotel_features', function (Blueprint $table) {
            $table->dropForeign('hotel_features_feature_id_foreign');
            $table->dropForeign('hotel_features_hotel_id_foreign');
        });
    }
}
