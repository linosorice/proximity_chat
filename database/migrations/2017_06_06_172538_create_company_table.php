<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->string('tax_code', 50)->nullable();
            $table->string('vat_number', 50)->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->string('address', 200)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('phone_number', 50)->nullable();
			$table->boolean('is_removed')->default(0);
			$table->dateTime('date_removed')->default(NULL)->nullable();
            $table->timestamps();
			
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
        Schema::dropIfExists('company');
    }
}
