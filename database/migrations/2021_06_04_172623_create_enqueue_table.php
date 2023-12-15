<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnqueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enqueue', function (Blueprint $table) {
            $table->uuid('id');

            $table->bigInteger('published_at');
            $table->text('body');
            $table->text('headers');
            $table->text('properties');
            $table->boolean('redelivered');
            $table->string('queue');
            $table->smallInteger('priority');
            $table->bigInteger('delayed_until');
            $table->bigInteger('time_to_live');
            $table->uuid('delivery_id');
            $table->bigInteger('redeliver_after');
            $table->primary('id');
            $table->index(['priority', 'published_at', 'queue', 'delivery_id', 'delayed_until', 'id'], 'multi');
            $table->index(['redeliver_after', 'delivery_id']);
            $table->index(['time_to_live', 'delivery_id']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enqueue');
    }
}
