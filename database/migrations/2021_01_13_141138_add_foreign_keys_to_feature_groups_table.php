<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFeatureGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feature_groups', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('feature_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feature_groups', function (Blueprint $table) {
            $table->dropForeign('feature_groups_category_id_foreign');
        });
    }
}
