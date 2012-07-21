<?php
//css assets
Asset::container('laradev-head')->bundle('laradev')->add('bootstrap', 'css/bootstrap.css');
Asset::container('laradev-head')->bundle('laradev')->add('bootstrap-responsive', 'css/bootstrap-responsive.css');
Asset::container('laradev-head')->bundle('laradev')->add('style', 'css/style.css');
//js assets
Asset::container('laradev-footer')->bundle('laradev')->add('modernizer', 'js/modernizr-2.5.3.min.js');
Asset::container('laradev-footer')->bundle('laradev')->add('prettify-js', 'js/prettify.js');
Asset::container('laradev-footer')->bundle('laradev')->add('bootstrap-alert', 'js/bootstrap-alert.js');
Asset::container('laradev-footer')->bundle('laradev')->add('scroll', 'js/scroll.js');

Route::controller(Controller::detect('laradev'));

Route::get('(:bundle)/login', array('as' => 'dev_login', 'do' => function(){
	return View::make('laradev::login');
}));

Route::post('(:bundle)/login', array('do'  => function() {

        $username = Input::get('username');
        $password = Input::get('password');
        
        if ( Auth::attempt( array('username' => $username, 'password' => $password)) )
        {
        	return Redirect::to_route('dev_index');
        }
        else
        {
	        return Redirect::to_route('dev_login')->with('errors', true);
        }

}));

Route::group(array('before' => 'auth'), function(){

	Route::get('(:bundle)/(:num?)', array('as' => 'dev_index', 'do' => function($id = ''){
		$users = DB::table('users')->paginate(5);
		if($id) 
		{
			$user = User::find($id);
			if( ! $user) return Response::error(500);
		}
		else $user = '';

		return View::make('laradev::user.index')
						->with('users', $users)
						->with('user', $user);
	}));

	Route::post('(:bundle)/new_user', function(){
		$input = Input::get();
		$user = new User();
		if($user->validate($input))
		{
			$data = array(
				'name' => Input::get('name'),
				'email' => Input::get('email'),
				'password' => Hash::make(Input::get('password'))
			);
			$create = User::create($data);
			return Redirect::to_route('dev_index');
		}

		return Redirect::to_route('dev_index')
							->with('errors', $user->errors())
							->with_input();
	});

	Route::post('(:bundle)/update_user', function(){
		$input = Input::get();
		$user = new User();
		if($user->validate($input))
		{
			$up_user = User::find(Input::get('id'));
			$up_user->name = Input::get('name'); 
			$up_user->email = Input::get('email'); 
			$up_user->password = Hash::make(Input::get('password'));

			$up_user->save();
			return Redirect::to_route('dev_index');
		}

		return Redirect::to_route('dev_index', array(Input::get('id')))
							->with('errors', $user->errors())
							->with_input();
	});

	Route::get('(:bundle)/del/(:num)', array('as' => 'del_dev_user' , 'do' => function($id){
		User::find($id)->delete();
		return Redirect::to_route('dev_index');
	}));

	Route::get('(:bundle)/(:num)/books', array('as' => 'user_books', 'to' => function($user_id){
		$user = User::find($user_id);
		$pivot = $user->books()->pivot();
		return View::make('laradev::user.books')
						->with('user', $user)
						->with('pivot', $pivot);
	}));

});

Route::get('(:bundle)/logout', array('as' => 'dev_logout', 'do' => function(){
	Auth::logout();	
	return Redirect::to_route('dev_login');
}));

/*
|--------------------------------------------------------------------------
| Application Events Handlers
|--------------------------------------------------------------------------
*/

Event::listen('laradev.new_user', function($id){
		$user = User::find($id);
		$user->email = $user->email.'_'.time();
		$user->save();
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to_route('dev_login');
});
