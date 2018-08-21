<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->string('name', 150);
            $table->text('description')->default(NULL)->nullable();
            $table->string('logo_image', 50)->default(NULL)->nullable();
            $table->bigInteger('city_id')->unsigned()->default(NULL)->nullable();
            $table->string('address', 200)->default(NULL)->nullable();
            $table->string('zip_code', 20)->default(NULL)->nullable();
            $table->string('phone_number', 50)->default(NULL)->nullable();
            $table->string('email', 200)->default(NULL)->nullable();
            $table->string('website', 200)->default(NULL)->nullable();
            $table->string('profile_facebook', 100)->default(NULL)->nullable();
            $table->string('profile_twitter', 100)->default(NULL)->nullable();
            $table->string('profile_youtube', 100)->default(NULL)->nullable();
            $table->string('profile_instagram', 100)->default(NULL)->nullable();
            $table->string('profile_linkedin', 100)->default(NULL)->nullable();
            $table->string('profile_pinterest', 100)->default(NULL)->nullable();
            $table->string('profile_tripadvisor', 100)->default(NULL)->nullable();
			$table->boolean('is_removed')->default(0);
			$table->dateTime('date_removed')->default(NULL)->nullable();
            $table->timestamps();
			
			$table->foreign('company_id')->references('id')->on('company');
			$table->foreign('city_id')->references('id')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
}
