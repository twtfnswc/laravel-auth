<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users',function($table){
			 $table->increments('id');
			 $table->text('email');
			 $table->text('username');
			 $table->text('password');
			 $table->text('passtemp');
			 $table->text('code');

			 $table->integer('active');
			 $table->timestamps();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users'); 
	}

}
