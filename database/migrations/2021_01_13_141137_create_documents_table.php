<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('userID')->nullable()->index('documents_userid_foreign');
            $table->smallInteger('status')->default(0)->comment('0-> Kontrol Bekliyor 1-> Onaylandı 2-> Onaylanmadı');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->string('reject_reason')->nullable();
            $table->integer('hotelId')->nullable();
            $table->string('creator')->nullable();
            $table->integer('adminId')->nullable();
            $table->boolean('hotel_preview')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
