<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->unsigned();
			$table->string('name', 150);
			$table->string('surname', 150)->nullable();
			$table->string('email', 200);
			$table->string('password', 150);
			$table->string('remember_token', 64)->default(NULL)->nullable();
			$table->boolean('is_removed')->default(0);
			$table->dateTime('date_removed')->default(NULL)->nullable();
            $table->timestamps();
			
			$table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
