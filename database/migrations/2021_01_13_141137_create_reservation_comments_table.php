<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id')->nullable()->index('reservation_comments_reservation_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable()->index('reservation_comments_customer_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('reservation_comments_user_id_foreign');
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_comments');
    }
}
