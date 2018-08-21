<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('group_id')->unsigned();
			$table->boolean('is_banned')->default(0);
			$table->dateTime('ban_date_end')->default(NULL)->nullable();
            $table->text('ban_reason')->default(NULL)->nullable();
            $table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('group_id')->references('id')->on('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
