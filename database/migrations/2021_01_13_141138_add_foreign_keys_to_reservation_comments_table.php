<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReservationCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation_comments', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
        Schema::table('reservation_comments', function (Blueprint $table) {
            $table->dropForeign('reservation_comments_customer_id_foreign');
            $table->dropForeign('reservation_comments_reservation_id_foreign');
            $table->dropForeign('reservation_comments_user_id_foreign');
        });
    }
}
