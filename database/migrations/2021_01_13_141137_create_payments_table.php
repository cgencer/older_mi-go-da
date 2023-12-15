<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('uuid', 36);
            $table->unsignedBigInteger('customer_id')->nullable()->index('payments_customer_id_foreign');
            $table->unsignedBigInteger('reservation_id')->nullable()->index('payments_reservation_id_foreign');
            $table->unsignedBigInteger('country_id')->nullable()->index('payments_country_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('hotel_id')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('application_fee')->nullable();
            $table->string('currency', 4)->nullable();
            $table->string('stripe_data', 255)->nullable();
            $table->enum('status', ['successed', 'declined', 'created', 'deleted', 'refunded', 'updated', 'captured', 'pending', 'closed', 'expiring', 'expired', 'finalized', 'paid', 'reversed', 'reinstated', 'submitted', 'completed', 'canceled', 'processing', 'attached', 'detached', 'opened', 'voided', 'applied', 'archived', 'failed', 'succeeded'])->nullable();
            $table->date('checkin')->nullable();
            $table->enum('proccess_status', ['hold', 'authed', 'charged', 'invoiced', 'paid', 'proced', 'stated', 'archived', 'cancelled', 'refunded'])->default('hold');
            $table->enum('invoice_status', ['non', 'draft', 'deleted', 'open', 'paid', 'uncollectible', 'void'])->default('non');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
