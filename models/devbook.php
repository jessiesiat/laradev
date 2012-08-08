<?php

Class DevBook extends Elegant {
	
	public static $table = 'laradev_books';

	protected $rules = array(
						'author' => 'required|min:2',
						'title' => 'required|min:2',
						'published' => 'required'
					);

	public function users()
	{
		return $this->has_many_and_belongs_to('DevUser', 'laradev_book_user');
	}

}