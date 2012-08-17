<?php

Class DevBook extends Elegant {
	
	public static $table = 'laradev_books';
	public static $accessible = array('title', 'author', 'desc');
	protected $rules = array(
						'author' => 'required|min:2',
						'title' => 'required|min:2',
						'desc' => 'required|min:12'
					);

	public function users()
	{
		return $this->has_many_and_belongs_to('DevUser', 'laradev_book_user');
	}

}