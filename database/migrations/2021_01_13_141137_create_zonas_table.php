<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->string('id', 32);
            $table->longText('alias')->nullable();
            $table->string('countrycode', 2)->nullable();
            $table->string('countryname', 48)->nullable();
            $table->string('note', 96)->nullable();
            $table->decimal('latitude', 20, 17)->nullable();
            $table->decimal('longitude', 20, 17)->nullable();
            $table->longText('offsets')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zonas');
    }
}
