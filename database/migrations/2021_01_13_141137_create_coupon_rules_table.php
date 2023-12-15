<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->tinyInteger('is_active');
            $table->timestamp('start_date')->nullable()->useCurrent();
            $table->timestamp('end_date')->nullable()->useCurrent();
            $table->tinyInteger('generate')->default(0);
            $table->string('prefix', 255)->default('1');
            $table->string('suffix', 255)->default('1');
            $table->smallInteger('length');
            $table->smallInteger('quantity');
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
        Schema::dropIfExists('coupon_rules');
    }
}
