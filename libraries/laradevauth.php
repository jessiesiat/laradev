<?php

class LaradevAuth {

	/**
	* Attempt to log in user
	*
	* @param array $arguments
	* @return boolean
	*/
	public static function attempt($arguments = array())
	{
		$user = DevUser::where('email', '=', $arguments['username'])->first();
						
		if( ! is_null($user) AND (Hash::check($arguments['password'], $user->password)))
		{
			Session::put('laradev_auth', $user->id);
			return true;
		}				
		else return false;		
	}

	/**
	* Determine of user is not currently login
	*
	* @return boolean
	*/
	public static function guest()
	{
		return ! (DevUser::find(Session::get('laradev_auth')));
		//return ! $this->user(Session::get('laradev_auth'));
	}

	public static function check()
	{
		return (DevUser::find(Session::get('laradev_auth')));
	}

	/**
	* Determine of user exists
	*
	* @return boolean
	*/
	protected function user($id)
	{
		 return DevUser::find($id);
		
	}

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
}