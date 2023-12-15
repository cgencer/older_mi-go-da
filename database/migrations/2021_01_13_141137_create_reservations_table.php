<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hotel_id')->nullable()->index('reservations_hotel_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable()->index('reservations_customer_id_foreign');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->smallInteger('status');
            $table->char('uuid', 36);
            $table->integer('guest_adult');
            $table->integer('guest_child');
            $table->longText('comments')->nullable();
            $table->string('main_guest', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->date('dob');
            $table->string('phone', 255)->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->longText('other_reason')->nullable();
            $table->integer('price')->nullable();
            $table->enum('gender', ['m', 'f', 'o'])->nullable()->comment('m => Male, f => Female, o => Other');
            $table->string('stripe_data', 255)->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
