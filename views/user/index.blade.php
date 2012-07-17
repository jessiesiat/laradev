@layout('laradev::layout.main')

@section('content')
<h2>Working with Routes</h2>
<p>The app below is a simple user entry form and maintainance which uses laravel routes to handle get and post request. I utilize <a href="http://laravel.com/docs/views/templating#blade-template-engine">laravel blade</a> template engine which uses braces for php tags and really! it looks clean!</p>
<hr/>
@if($user)
<h3>Update User Form</h3>
	@if(Session::has('errors'))
		<p class="alert alert-error">
		<button class="close in fade alert" data-dismiss="alert">×</button>
		{{ $errors->first('name', ':message<br/>') }} 
		{{ $errors->first('email', ':message<br/>') }}
		{{ $errors->first('password', ':message<br/>') }}
		</p>
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
		<p>{{ Form::submit('Update User', array('class' => 'btn')) }}</p>
	{{ Form::close() }}
@else
<h3>New User Form</h3>
	@if(Session::has('errors'))
		<p class="alert alert-error">
		<button class="close in fade alert" data-dismiss="alert">×</button>
		{{ $errors->first('name', ':message<br/>') }} 
		{{ $errors->first('email', ':message<br/>') }}
		{{ $errors->first('password', ':message<br/>') }}
		</p>
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
		<p>{{ Form::submit('Submit User', array('class' => 'btn')) }}</p>
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
  	@forelse($users as $user)
  	<tr>
		<td>{{ $user->id }}</td>
		<td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->created_at }}</td><td>{{ $user->updated_at }}</td>
		<td>{{ HTML::link('laradev/'.$user->id, 'Edit') }} | <a href="{{ URL::to_route('del_dev_user', array($user->id)) }}" onclick="return confirm('Are you sure?')">delete</a></td>
	</tr>
	@empty
	<tr>
		<td td colspan="6">No data found.</td>
	</tr>
	@endforelse
</tbody>
</table> 
<blockquote>
  <p>Dont leave the users empty you need it for login to view this page.</p>
</blockquote>
<hr/>
<h2>The Code</h2>
<hr/>
<h4>Route</h4>
<pre class="prettyprint linenums">
//application\routes.php
Route::get('user/(:num?)', array('before' => 'auth', 'do' => function($id){
	$users = Users::all();
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

Route::post('new_user', array('before' => 'auth', 'do' => function(){
	$data = array(
		'name' => Input::get('name'),
		'email' => Input::get('email'),
		'password' => Hash::make(Input::get('password'))
	);
	$user = new User($data);
	$user->save();

	return Redirect::to('user');
}));

Route::post('update_user', function(){
	$user = new User();
	$rules = array(
				'name' => 'required',
				'email' => 'required|email',
				'password' => 'required|confirmed'
			);
	$validation = Validator::make(Input::get(), $rules);
	if($validation->success())
	{
		$up_user = User::find(Input::get('id'));
		$up_user->name = Input::get('name'); 
		$up_user->email = Input::get('email'); 
		$up_user->password = Hash::make(Input::get('password'));

		$up_user->save();
		return Redirect::to('user');
	}

	return Redirect::to('user/'.Input::get('id'))
						->with_errors($validation)
						->with_input();
});

Route::get('del_user/(:num)', array('before' => 'auth', 'do' => function($id){
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
<dl>some desc</dl>
<pre class="prettyprint linenums">
//application\views\user\index.blade.php
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
		[[ Form::submit('Update User', array('class' => 'btn')) ]]
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
		[[ Form::submit('Submit User', array('class' => 'btn')) ]]
[[ Form::close() ]]
#endif
List of User
ID | Name | Email | Created At | Updated At | Action
  	#forelse($users as $user)
		[[ $user->id ]] [[ $user->name ]] | [[ $user->email ]] |
		[[ $user->created_at ]] | [[ $user->updated_at ]]
		[[ HTML::link('laradev/'.$user->id, 'Edit') ]] | 
		(html < a tag) href="[[ URL::to('del_user/'.$user->id) ]]" 
		onclick="return confirm('Are you sure?')">delete(html > a tag)
	#empty
		No data found.
	#endforelse
</tbody>
</table> 
</pre>

@endsection