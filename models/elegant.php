<?php

/*
/	@package:	Laradev ~ a bundle for laravel
/	@author:	Jessie Siat
/	@email: 	jecrs.siat@gmail.com
/	@version:	1.0
*/

class Elegant extends Eloquent {

	protected $rules = array();
	protected $errors;

	public function validate($data)
	{
		//make a new validator object
		$v = Validator::make($data, $this->rules);

		//check if failure
		if( $v->fails() )
		{
			//set errors and return false
			$this->errors = $v->errors;

			return false;
		}

		//validation pass
		return true;
	}

	public function errors()
	{
		return $this->errors;
	}

}