<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentsTableStatusFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('proccess_status');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('proccess_status', ['preflight', 'hold', 'authed', 'charged', 'invoiced', 'paid', 'proced', 'stated', 'archived', 'cancelled', 'refunded'])->default('preflight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
