@layout('Laradev::layout.main')

@section('content')

    <h3>Book: {{ $book->title }}</h3>
	<h4>Provide a Copy to:</h4>
	<br/>
	{{ Form::open('laradev/book/copy', 'POST', array('class' => 'form-inline')) }}
		{{ Form::hidden('book_id', $book->id) }}
		{{ Form::label('user', 'Name') }}
		<select name="user_id">
			@foreach ($users as $user)
				<option value="{{ $user->id }}">{{ $user->name }}</option>
			@endforeach
		</select>
		{{ Form::submit('Go!', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}

@endsection