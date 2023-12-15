<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('uuid', 36);
            $table->bigInteger('oldID')->nullable();
            $table->string('name');
            $table->string('username');
            $table->string('email', 120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('enabled')->default(0);
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->smallInteger('prefix')->nullable();
            $table->string('country', 3)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('date_of_birth', 30)->nullable();
            $table->string('website', 64)->nullable();
            $table->string('biography', 1000)->nullable();
            $table->string('gender')->nullable()->comment('m => Male, f => Female, o => Other');
            $table->string('stripe_data', 255)->nullable();
            $table->string('locale', 8)->nullable();
            $table->string('timezone', 64)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->string('email_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
