<?php

class Laradev_Create_Laradev_Book_User_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('laradev_book_user', function($table){
			$table->increments('id');
			$table->integer('devuser_id');
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
		Schema::drop('laradev_book_user');
	}

}