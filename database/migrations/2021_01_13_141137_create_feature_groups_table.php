<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lang_key')->nullable();
            $table->text('name');
            $table->string('type')->nullable();
            $table->tinyInteger('filter')->default(0);
            $table->unsignedBigInteger('category_id')->nullable()->index('feature_groups_category_id_foreign');
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
        Schema::dropIfExists('feature_groups');
    }
}
