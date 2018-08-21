<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeaconTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->string('uuid', 50);
            $table->string('major', 50)->default(NULL)->nullable();
            $table->string('minor', 50)->default(NULL)->nullable();
            $table->bigInteger('store_id')->unsigned();
			$table->boolean('is_enabled')->default(1);
			$table->boolean('is_removed')->default(0);
			$table->dateTime('date_removed')->default(NULL)->nullable();
            $table->timestamps();
			
			$table->foreign('store_id')->references('id')->on('store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beacon');
    }
}
