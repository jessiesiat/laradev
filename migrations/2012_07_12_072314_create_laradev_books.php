<?php

class Laradev_Create_Laradev_Books {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('laradev_books', function($table){
			$table->increments('id');
			$table->string('title', 64);
			$table->string('author', 128);
			$table->date('published');
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
		Schema::drop('laradev_books');
	}

}