<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('connected_id');
            $table->enum('connected_model', ['Hotels', 'User', 'Customers', 'Reservation']);
            $table->enum('modus', ['persona', 'id']);
            $table->string('path', 64)->nullable();
            $table->string('data', 255)->nullable();
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
        Schema::dropIfExists('stripe_data');
    }
}
