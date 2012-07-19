<?php

class Laradev_Create_Laradev_Books_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('laradev_books_users', function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('devbook_id');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('laradev_books_users');
	}

}