<?php

class User extends Elegant {

	protected $rules = array(
						'name' => 'required',
						'email' => 'required|email',
						'password' => 'required|confirmed'
					);

	public function books()
	{
		$this->has_many_and_belongs_to('Devbook', 'laradev_books_users');
	}

}