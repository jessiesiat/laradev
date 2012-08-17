<?php

class LaradevAuth {

	/**
	 * The current value of the user's token
	 * 
	 * @var int/null
	 */
	public $token;

	/*
  	 * Current driver being user
  	 *
  	 * @var string
	 */
	static $driver = array();

	public function __construct() {}

	/**
	 * Logout the current logged in user
	 *
	 * @return boolean
	 */
	public static function logout()
	{
		Session::forget('laradev_auth');
		return true;
	}

	public static function driver()
	{
		return new Laradevdrivers\Eloquent();
	}

	public static function __callStatic($method, $param)
	{
		return call_user_func_array(array(static::driver(), $method), $param);
	}
}