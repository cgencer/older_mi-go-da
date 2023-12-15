<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventTypeToWebHookCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webhook_calls', function (Blueprint $table) {
            $table->string('event_type', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webhook_calls', function (Blueprint $table) {
            $table->dropColumn('event_type');
        });
    }
}
