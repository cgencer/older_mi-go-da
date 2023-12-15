<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('oldID')->nullable();
            $table->longText('name');
            $table->longText('slug');
            $table->longText('description')->nullable();
            $table->longText('address')->nullable();
            $table->text('categories')->nullable();
            $table->decimal('latitude', 14, 8)->nullable();
            $table->decimal('longitude', 14, 8)->nullable();
            $table->tinyInteger('star_id')->nullable()->comment('1,2,3,4,5 and 6 => Unrated');
            $table->tinyInteger('is_verified')->default(0);
            $table->unsignedBigInteger('board_food_allowance_id')->nullable()->index('hotels_board_food_allowance_id_foreign');
            $table->integer('price')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('hotels_user_id_foreign');
            $table->tinyInteger('is_enabled')->default(0);
            $table->tinyInteger('gift_for_migoda_guests')->default(0);
            $table->longText('gift_description')->nullable();
            $table->string('sku', 255);
            $table->string('contact_person', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_phone', 255)->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->index('hotels_country_id_foreign');
            $table->string('imdlisting', 255)->nullable();
            $table->longText('imgallery')->nullable();
            $table->text('city')->nullable();
            $table->char('uuid', 36);
            $table->text('guid')->nullable();
            $table->string('imdcheckout', 255)->nullable();
            $table->string('imdmap', 255)->nullable();
            $table->string('imddetail', 255)->nullable();
            $table->string('immlisting', 255)->nullable();
            $table->string('immcheckout', 255)->nullable();
            $table->string('immdetail', 255)->nullable();
            $table->string('stripe_data', 255)->nullable();
            $table->longText('property_description')->nullable();
            $table->string('property_checkin')->nullable();
            $table->timestamps();
            $table->string('website', 250)->nullable();
            $table->string('property_checkout')->nullable();
            $table->decimal('comission_rate', 4, 1)->default(12.5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
