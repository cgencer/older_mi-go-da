<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('rel_type', 24);                         // stat belongs to (hotel/customer/country/region)
            $table->integer('rel_id');                              // id of hotel/customer 
            $table->integer('for_year')->nullable()->default(2021); 
            $table->integer('for_quarter')->nullable()->default(1);
            $table->integer('for_month')->nullable()->default(1);   // 0s are ALWAYS the SUM of last month
            $table->integer('for_week')->nullable()->default(1);    // week of year!
            $table->integer('for_day')->nullable()->default(1);
            $table->integer('val')->default(0);                     // calculated value for statistics for day/month/year
            $table->longtext('extras')->nullable();                 // json data if needed (e.g. list of hotels etc)
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
        Schema::dropIfExists('stats');
    }
}
