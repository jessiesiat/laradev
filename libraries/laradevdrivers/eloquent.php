<?php namespace Laradevdrivers; 

use Laravel\Hash, Laravel\Config, Laravel\Session;

class Eloquent {

	/**
	 * The current value of the user's token
	 * 
	 * @var int/null
	 */
	public $token;

	/**
	 * The currently logged in user
	 * 
	 * @var int/null
	 */
	public $user;

	public function __construct()
	{
		if (Session::started())
		{
			$this->token = Session::get($this->token());
		}
	}

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
			$this->login($user->id, array_get($arguments, 'remember'));

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

	/**
	 * Determine of user exists
	 *
	 * @return boolean
	 */
	protected function user()
	{
		if( ! is_null($this->user)) return $this->user;

		return $this->user = $this->retrieve($this->token);	
	}

	/**
	 * Get the current user of the application
	 *
	 * @param int    $id
	 * @return mixed/null
	 */
	public function retrieve($id)
	{
		if (filter_var($id, FILTER_VALIDATE_INT) !== false)
		{
			return $this->model()->find($id);
		}
	}

	/**
	 * Login the user token
	 *
	 * @return boolean
	 */
	public function login($token, $remember = false)
	{
		$this->token = $token;

		$this->store($token);

		return true;
	}

	/**
	 * Store the token of the current logged in user in session
	 *
	 * @return null
	 */
	protected function store($token)
	{
		Session::put($this->token(), $token);
	}

	public function logout()
	{
		$this->user = null;

		Session::forget($this->token());
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

	/**
	 * Token name use for loggin user
	 *
	 * @return mixed
	 */
	protected function token()
	{
		return 'laradev_auth';
	}

}