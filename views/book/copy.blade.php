@layout('Laradev::layout.main')

@section('content')
    <h3>Book: <em>{{ $book->title }}</em></h3>
	<br/>
	{{ Form::open('laradev/book/copy', 'POST', array('class' => 'form-inline')) }}
		{{ Form::hidden('book_id', $book->id) }}
		{{ Form::label('user', 'Provide a Copy to: ') }}
		<select name="user_id">
			@foreach ($users as $user)
				<option value="{{ $user->id }}">{{ $user->name }}</option>
			@endforeach
		</select>
		{{ Form::submit(' Continue', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
<hr/>
<h3>Source Code</h3>
<p>We now include relationships(many to many) in our model <em>User</em> and <em>Book</em> in here. We now utilize the Eloquent Laravel ORM which makes working with model relationships a breeze.</p>

<h4>Controller<h4>
<pre class="prettyprint linenums">
//application\controller\book.php
public function get_copy($id = '')
{
	if ( ! $id) return Redirect::to_action('book@index');
	$book = Book::find($id);
	$users = User::all();
	return View::make('book.copy')
					->with('book', $book)
					->with('users', $users);
}
public function post_copy()
{
	$book = Book::find(Input::get('book_id'));
	$book->users()->attach(Input::get('user_id'));
	return Redirect::to_action('book@index');
}
</pre>

<h4>Model<h4>
<pre class="prettyprint linenums">
//application\models\user.php
public function books()
{
	return $this->has_many_and_belongs_to('User');
}

//application\models\book.php
public function users()
{
	return $this->has_many_and_belongs_to('Book');
}
</pre>

<h4>View<h4>
<pre class="prettyprint linenums">
Book: [[ $book->title ]]
Provide a Copy to:
[[ Form::open('book/copy') ]]
	[[ Form::hidden('book_id', $book->id) ]]
	[[ Form::label('user', 'Name') ]]
	(select name="user_id")
		#foreach ($users as $user)
			(option value="[[ $user->id ]]")[[ $user->name ]](/option)
		#endforeach
	(/select)
	[[ Form::submit('Go!') ]]
[[ Form::close() ]]	
</pre>

@endsection