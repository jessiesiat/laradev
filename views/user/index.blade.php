@layout('laradev::layout.main')
@section('content')
<h2>Manage Users</h2>
<p>A simple user management app.</p>
<hr/>
@if($user)
<h3>Update User Form</h3>
	@if(Session::has('errors'))
		<div class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('name', ':message<br/>') }} 
		{{ $errors->first('email', ':message<br/>') }}
		{{ $errors->first('password', ':message<br/>') }}
		</div>
	@endif
	{{ Form::open('laradev/update_user') }}
		{{ Form::hidden('id', $user->id) }}
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name', $user->name) }}
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email', $user->email) }}
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password') }}
		{{ Form::label('password_confirmation', 'Confirm Password') }}
		{{ Form::password('password_confirmation') }}
		<p>{{ Form::submit('Update User', array('class' => 'btn btn-primary')) }} or {{ HTML::link('laradev', 'Cancel') }}</p>
	{{ Form::close() }}
@else
<h3>New User Form</h3>
	@if(Session::has('errors'))
		<div class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('name', ':message<br/>') }} 
		{{ $errors->first('email', ':message<br/>') }}
		{{ $errors->first('password', ':message<br/>') }}
		</div>
	@endif
	{{ Form::open('laradev/new_user') }}
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name', Input::old('name')) }}
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email', Input::old('email')) }}
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password') }}
		{{ Form::label('password_confirmation', 'Confirm Password') }}
		{{ Form::password('password_confirmation') }}
		<p>{{ Form::submit('Submit User', array('class' => 'btn btn-primary')) }}</p>
	{{ Form::close() }}
@endif
<h3>List of Users</h3>
<table class="table table-striped table-condensed table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Created At</th><th>Updated At</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
  	@forelse($users->results as $user)
  	<tr>
		<td>{{ $user->id }}</td>
		<td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->created_at }}</td><td>{{ $user->updated_at }}</td>
		<td>{{ HTML::decode(HTML::link('laradev/'.$user->id, '<i class="icon-edit"></i>', array('title' => 'edit', 'alt' => 'edit'))) }} | <a href="{{ URL::to_route('del_dev_user', array($user->id)) }}" onclick="return confirm('Are you sure?')" alt="delete" title="delete"><i class="icon-trash"></i></a> | <a href="{{ URL::to_route('user_books', array($user->id)) }}" alt="books" title="books"><i class="icon-book"></i></a></td>
	</tr>
	@empty
	<tr>
		<td td colspan="6">No data found.</td>
	</tr>
	@endforelse
</tbody>
</table> 
{{ $users->links() }}
<blockquote>
  <p>Dont leave the users empty you need it for login to view this page.</p>
</blockquote>
<hr/>
<h3>Source Code</h3>
<p>The app above is a simple user entry form and maintainance which uses laravel routes to handle get and post request. I utilize <a href="http://laravel.com/docs/views/templating#blade-template-engine">laravel blade</a> template engine which uses braces for php tags and really! it looks clean!</p>
<p>To learn more on routing with laravel visit <a href="http://laravel.com/docs/routing" target="_blank">Laravel routing documentation</a>.</p>
<p>Please refer to the laravel documentation if you did not understand some code. Quick links are prodived on the side.</p>
<hr/>
<h4>Route</h4>
<pre class="prettyprint linenums">
//application\routes.php
Route::get('user/(:num?)', array('before' => 'auth', function($id){
	$users = DB::table('users')->paginate(5);
	if($id)
	{
		$user = User::find($id);
		if( ! $user) return Response::error(500);
	}
	else $user = '';

	return View::make('user.index')
					->with('users', $users)
					->with('user', $user);
}));

Route::post('new_user', array('before' => 'auth', function(){
	$data = array(
		'name' => Input::get('name'),
		'email' => Input::get('email'),
		'password' => Hash::make(Input::get('password'))
	);
	$user = new User($data);
	$user->save();

	return Redirect::to('user');
}));

Route::post('update_user', array('before' => 'auth', function(){
	$rules = array(
				'name' => 'required',
				'email' => 'required|email',
				'password' => 'required|confirmed'
			);
	$validate = Validator::make(Input::get(), $rules);
	if($validate->success())
	{
		$up_user = User::find(Input::get('id'));
		$up_user->name = Input::get('name'); 
		$up_user->email = Input::get('email'); 
		$up_user->password = Hash::make(Input::get('password'));

		$up_user->save();
		return Redirect::to('user');
	}

	return Redirect::to('user/'.Input::get('id'))
						->with_errors($validate)
						->with_input();
}));

Route::get('del_user/(:num)', array('before' => 'auth', function($id){
	$user = User::find($id);
	$user->delete();
	return Redirect::to('user');
}));
</pre>

<h4>Model</h4>
<pre class="prettyprint linenums">
//application\model\user.php
Class User extends Eloquent{}
</pre>

<h4>View</h4>
<pre class="prettyprint linenums">
//application\views\user\index.blade.php
#if(Session::has('errors'))
	[[ $errors->first('name', ':message') ]] 
	[[ $errors->first('email', ':message') ]]
	[[ $errors->first('password', ':message') ]]
#endif
#if ($user)
Update User Form
[[ Form::open('update_user') ]]
		[[ Form::hidden('id', $user->id) ]]
		[[ Form::label('name', 'Name') ]]
		[[ Form::text('name', $user->name) ]]
		[[ Form::label('email', 'Email') ]]
		[[ Form::text('email', $user->email) ]]
		[[ Form::label('password', 'Password') ]]
		[[ Form::password('password') ]]
		[[ Form::label('password_confirmation', 'Confirm Password') ]]
		[[ Form::password('password_confirmation') ]]
		[[ Form::submit('Update User') ]] or [[ HTML::link('user', 'Cancel') ]]
[[ Form::close() ]]
#else
New User Form
[[ Form::open('new_user') ]]
		[[ Form::label('name', 'Name') ]]
		[[ Form::text('name', Input::old('name')) ]]
		[[ Form::label('email', 'Email') ]]
		[[ Form::text('email', Input::old('email')) ]]
		[[ Form::label('password', 'Password') ]]
		[[ Form::password('password') ]]
		[[ Form::label('password_confirmation', 'Confirm Password') ]]
		[[ Form::password('password_confirmation') ]]
		[[ Form::submit('Submit User') ]]
[[ Form::close() ]]
#endif
List of User
ID | Name | Email | Created At | Updated At | Action
  	#forelse($users->results as $user)
		[[ $user->id ]] [[ $user->name ]] | [[ $user->email ]] |
		[[ $user->created_at ]] | [[ $user->updated_at ]]
		[[ HTML::link('user/'.$user->id, 'Edit') ]] | 
		(html < a tag) href="[[ URL::to('del_user/'.$user->id) ]]" 
		onclick="return confirm('Are you sure?')">delete(html > a tag)
	#empty
		No data found.
	#endforelse
	[[ $users->links() ]]
</pre>

@endsection
