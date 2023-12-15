<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->string('code', 3)->nullable();
            $table->char('iso3', 3)->nullable();
            $table->smallInteger('prefix')->nullable();
            $table->timestamps();
            $table->string('currency', 3);
            $table->string('currency_symbol', 8);
            $table->string('currency_name', 64);
            $table->integer('conversion_rate');
            $table->string('postal_code_format', 64)->nullable();
            $table->string('postal_code_regex', 64)->nullable();
            $table->string('languages', 128)->nullable();
            $table->double('timezone_id', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
