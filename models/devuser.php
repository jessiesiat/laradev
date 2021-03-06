<?php

class DevUser extends Elegant {
	
	public static $table = 'laradev_users';
	public static $accessible = array('name', 'email', 'password');
	protected $rules = array(
						'name' => 'required',
						'email' => 'required|email',
						'password' => 'required|confirmed'
					);

	public function books()
	{
		return $this->has_many_and_belongs_to('Devbook', 'laradev_book_user');
	}

}