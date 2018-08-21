<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_rc', 50);
            $table->bigInteger('store_id')->unsigned()->default(NULL)->nullable();
            $table->string('name', 150);
            $table->string('latitude', 50)->default(NULL)->nullable();
            $table->string('longitude', 50)->default(NULL)->nullable();
            $table->bigInteger('access_distance_range')->default(NULL)->nullable();
            $table->time('time_start')->default(NULL)->nullable();
            $table->time('time_end')->default(NULL)->nullable();
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
        Schema::dropIfExists('group');
    }
}
