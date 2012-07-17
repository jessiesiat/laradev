<?php

class Laradev_Create_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');
			$table->string('name', 64);
			$table->string('email', 128);
			$table->string('password', 64);
			$table->timestamps();
		});

		DB::table('users')->insert(
			'name' => 'Juan',
			'email' => 'juan@ph.ph',
			'password' => Hash::make('juan123')
			);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}