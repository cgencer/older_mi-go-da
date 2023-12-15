<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentsTableAddMoreStatusFlags extends Migration
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
            $table->enum('proccess_status', ['preflight', 'hold', 'authed', 'sub2', 'sub7', 'fees', 'nofees', 'docharges', 'charged', 'invoiced', 'paid', 'proced', 'stated', 'archived', 'cancelled', 'refunded'])->default('preflight');
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