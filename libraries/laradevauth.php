<?php

class LaradevAuth {

	/*
  	 * Current driver being user
  	 *
  	 * @var string
	 */
	static $driver = array();

	public function __construct() {}

	public static function driver()
	{
		return new Laradevdrivers\Eloquent();
	}

	public static function __callStatic($method, $param)
	{
		return call_user_func_array(array(static::driver(), $method), $param);
	}
}