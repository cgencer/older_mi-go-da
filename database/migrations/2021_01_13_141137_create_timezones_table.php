<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimezonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->string('country_code', 3);
            $table->string('timezone', 125)->default('');
            $table->double('gmt_offset', 10, 2)->nullable();
            $table->double('dst_offset', 10, 2)->nullable();
            $table->double('raw_offset', 10, 2)->nullable();
            $table->primary(['country_code', 'timezone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timezones');
    }
}
