<?php

class Laradev_Create_Laradev_Books_Table {

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
			$table->text('desc');
			$table->string('author', 128);
			$table->date('published');
			$table->timestamps();
		});

		DB::table('laradev_books')->insert(array(
			'title' => 'Code Happy',
			'desc' => 'Web development with the Laravel PHP framework',
			'author' => 'Dayle Rees'
		));
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