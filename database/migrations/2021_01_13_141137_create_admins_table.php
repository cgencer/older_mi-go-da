<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('email', 120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('enabled')->default(0);
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone', 64)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('date_of_birth', 30)->nullable();
            $table->string('website', 64)->nullable();
            $table->string('biography', 1000)->nullable();
            $table->enum('gender', ['m', 'f', 'o'])->nullable()->comment('m => Male, f => Female, o => Other');
            $table->string('locale', 8)->nullable();
            $table->string('timezone', 64)->nullable();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('admins');
    }
}
