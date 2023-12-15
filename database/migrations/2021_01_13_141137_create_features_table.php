<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->string('filename', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('oldID', 255)->nullable();
            $table->unsignedBigInteger('group_id')->nullable()->index('features_group_id_foreign');
            $table->timestamps();
            $table->boolean('filter')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
