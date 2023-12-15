<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStripeDatasToLongtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->mediumText('stripe_data')->comment(' ')->change();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->mediumText('stripe_data')->comment(' ')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->mediumText('stripe_data')->comment(' ')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
