<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('oldID')->nullable();
            $table->char('uuid', 36);
            $table->text('name');
            $table->text('slug');
            $table->integer('position')->nullable();
            $table->string('filename')->nullable();
            $table->string('filename_red')->nullable();
            $table->string('bg_filename')->nullable();
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
        Schema::dropIfExists('hotel_categories');
    }
}
