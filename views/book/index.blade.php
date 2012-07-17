@layout('laradev::layout.main')

@section('content')

<h2>Working with Controllers</h2>
<p>As what we are familiar with, lets work with C(Controller)in MVC. This is where we write code that communicates to our M(Model) where the business entities is being defined and display it in the V(Views). The app below is a simple book management/inventory. Take a look and try how it works!</p>
<hr/>
@if ($book)
<h3>Update Book Form</h3>
	@if(Session::has('errors'))
		<p class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('title', ':message<br/>') }} 
		{{ $errors->first('author', ':message<br/>') }}
		{{ $errors->first('published', ':message<br/>') }}
		</p>
	@endif
	{{ Form::open('laradev/book/update') }}
		{{ Form::hidden('id', $book->id) }}
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', $book->title) }}
		{{ Form::label('author', 'Author') }}
		{{ Form::text('author', $book->author) }}
		{{ Form::label('published', 'Date Published') }}
		{{ Form::text('published', $book->published, array('placeholder' => 'yy-mm-dd')) }}
		<p>{{ Form::submit('Update Book', array('class' => 'btn btn-primary')) }}</p>
	{{ Form::close() }}
@else
<h3>New Book Form</h3>
	@if(Session::has('errors'))
		<p class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('title', ':message<br/>') }} 
		{{ $errors->first('author', ':message<br/>') }}
		{{ $errors->first('published', ':message<br/>') }}
		</p>
	@endif
	{{ Form::open('laradev/book/new') }}
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', Input::old('title')) }}
		{{ Form::label('author', 'Author') }}
		{{ Form::text('author', Input::old('author')) }}
		{{ Form::label('published', 'Date Published') }}
		{{ Form::text('published', Input::old('published'), array('placeholder' => 'yy-mm-dd')) }}
		<p>{{ Form::submit('Submit Book', array('class' => 'btn btn-primary')) }}</p>
	{{ Form::close() }}
@endif
<hr/>

<table class="table table-striped table-condensed table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Title</th><th>Author</th><th>Published</th><th>Created At</th><th>Updated At</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
  	@forelse($books->results as $book)
  	<tr>
		<td>{{ $book->id }}</td>
		<td>{{ $book->title }}</td><td>{{ $book->author }}</td><td>{{ $book->published }}</td><td>{{ $book->created_at }}</td><td>{{ $book->updated_at }}</td>
		<td> <a href="{{ action('Laradev::book@index', array($book->id)) }}">edit</a> | <a onclick="return confirm('Are you sure?')" href="{{ action('Laradev::book@delete', array($book->id)) }}">delete</a></td>
	</tr>
	@empty
	<tr>
		<td td colspan="6">No book in the shelf.</td>
	</tr>
	@endforelse
</tbody>
</table>
{{ $books->links() }}
<hr/>
<h4>Controller</h4>
<pre class="prettyprint linenums">
//application/controller/book.php
class Book_Controller extends Base_Controller {
	
	public $restful = true;
	protected $rules = array(
					'author' => 'required',
					'title' => 'required',
					'published' => 'required'
				);

	public function get_index()
	{
		$books = DB::table('books')->paginate(5);
		return View::make('book.index')->with('books', $books);
	}

	public function post_new()
	{
		$data = array(
				'title' => Input::get('title'),
				'author' => Input::get('author'),
				'published' => Input::get('published')
			);

		$validate = Validator::make($data, $this->rules);

		if($validate->success())
		{
			Book::create($data);
			return Redirect::to_action('book@index');
		}

		return Redirect::to_action('book@index')
							->with('errors', $book->errors())
							->with_input();
	}

	public function post_update()
	{
		$input = Input::get();
		
		$validate = Validator::make($input, $this->rules);

		if($validate->success())
		{
			$up_book = Devbook::find(Input::get('id'));
			$up_book->author = Input::get('author');
			$up_book->title = Input::get('title');
			$up_book->published = Input::get('published');

			$up_book->save();
			return Redirect::to_action('book@index')
								->with('notify', 'Successfuly updated book.');
		}

		return Redirect::to_action('book@index', array(Input::get('id')))
							->with_errors('errors', $book->errors());
	}


	public function get_delete($id)
	{
		Book::find($id)->delete();
		return Redirect::to_action('book@index');
	}

}
</pre>

<h4>Model</h4>
<pre class="prettyprint linenums">
//applications\models\book.php
Class Book extends Eloquent {}
</pre>


<h4>View</h4>
<pre class="prettyprint linenums">
//applications\views\book\index.php
#if ($book)
[[ Form::open('book/update') ]]
	[[ Form::hidden('id', $book->id) ]]
	[[ Form::label('title', 'Title') ]]
	[[ Form::text('title', $book->title) ]]
	[[ Form::label('author', 'Author') ]]
	[[ Form::text('author', $book->author) ]]
	[[ Form::label('published', 'Date Published') ]]
	[[ Form::text('published', $book->published, array('placeholder' => 'yy-mm-dd')) ]]
	[[ Form::submit('Update Book', array('class' => 'btn btn-primary')) ]]
[[ Form::close() ]]
#else 
[[ Form::open('book/new') ]]
	[[ Form::label('title', 'Title') ]]
	[[ Form::text('title', Input::old('title')) ]]
	[[ Form::label('author', 'Author') ]]
	[[ Form::text('author', Input::old('author')) ]]
	[[ Form::label('published', 'Date Published') ]]
	[[ Form::text('published', Input::old('published'), array('placeholder' => 'yy-mm-dd')) ]]
	[[ Form::submit('Update Book') ]]
[[ Form::close() ]]
#endif
</pre>

@endsection