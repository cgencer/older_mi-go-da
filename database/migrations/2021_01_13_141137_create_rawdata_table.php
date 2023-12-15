<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rawdata', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('modus', ['SHEET', 'HOTEL']);
            $table->bigInteger('dbId')->nullable();
            $table->string('country', 2);
            $table->string('cellpos')->nullable();
            $table->string('lang', 2);
            $table->text('celldata');
            $table->enum('colname', ['name', 'slug', 'description'])->nullable();
            $table->string('status', 32)->default('OOOOO');
            $table->unsignedInteger('hash')->nullable();
            $table->timestamp('checksum_at')->nullable();
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
        Schema::dropIfExists('rawdata');
    }
}
