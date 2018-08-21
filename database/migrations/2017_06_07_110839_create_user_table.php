<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// creazione tabella User
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_rc', 50);
            $table->string('name', 150);
            $table->string('nickname', 150);
            $table->string('email', 200);
            $table->string('password', 150);
            $table->date('date_of_birth', 150)->default(NULL)->nullable();
            $table->string('gender', 150)->default(NULL)->nullable();
            $table->bigInteger('relationship_status_id')->unsigned()->nullable();
            $table->string('avatar', 150)->default(NULL)->nullable();
			$table->boolean('is_view_name')->default(0)->nullable();
			$table->boolean('is_view_age')->default(0)->nullable();
			$table->boolean('is_view_gender')->default(0)->nullable();
			$table->boolean('is_agree_private_chat')->default(0)->nullable();
			$table->boolean('is_agree_public_position')->default(0)->nullable();
			$table->boolean('is_removed')->default(0);
			$table->dateTime('date_removed')->default(NULL)->nullable();
            $table->timestamps();
			
			$table->foreign('relationship_status_id')->references('id')->on('relationship_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
