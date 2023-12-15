<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreign('board_food_allowance_id')->references('id')->on('features')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('hotels_board_food_allowance_id_foreign');
            $table->dropForeign('hotels_country_id_foreign');
            $table->dropForeign('hotels_user_id_foreign');
        });
    }
}
