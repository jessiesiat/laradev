<?php namespace Laradevdrivers; 

use Laravel\Hash, Laravel\Config, Laravel\Session;

class Eloquent {

	/**
	 * The current user being manage by the application
	 * 
	 * @var mixed
	 */
	public $user;

	/**
	 * Attempt to log in user
	 *
	 * @param array $arguments
	 * @return boolean
	 */
	public function attempt($arguments = array())
	{
		$user = $this->model()->where('email', '=', $arguments['username'])->first();
						
		if( ! is_null($user) and (Hash::check($arguments['password'], $user->password)))
		{
			Session::put('laradev_auth', $user->id);
			//$this->token = $user->id;
			//$this->user = $user;

			return true;
		}				
		else return false;		
	}

	/**
	 * Determine of user is not currently login
	 *
	 * @return boolean
	 */
	public function guest()
	{
		return ! $this->check();
	}

	/**
	 * Determine of user is currently login
	 *
	 * @return boolean
	 */
	public function check()
	{
		return ! is_null($this->user());
	}

	public static function con($name)
	{
		echo 'He yo! '.$name;
	}

	/**
	 * Determine of user exists
	 *
	 * @return boolean
	 */
	protected function user()
	{
		 return $this->user = $this->model()->find(Session::get('laradev_auth'));
	}

	/**
	 * Get the laradev bundle model instance
	 *
	 * @return Eloquent
	 */
	protected function model()
	{
		$model = Config::get('laradev::laradev.model');

		return new $model;
	}

}