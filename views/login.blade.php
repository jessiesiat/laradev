@layout('laradev::layout.main')

@section('content')
	{{ Form::open('laradev/login') }}

		@if (Session::has('errors'))
			<span class="error">Incorrect username or password</span>
		@endif
		<div class="login">
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username') }}
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }} 
			<p>{{ Form::submit('Login', array('class'=> 'btn btn-primary')) }}</p>
		</div>
	{{ Form::close() }}
@endsection