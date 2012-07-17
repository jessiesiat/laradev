<?php

class User extends Elegant {

	protected $rules = array(
						'name' => 'required',
						'email' => 'required|email',
						'password' => 'required|confirmed'
					);

}