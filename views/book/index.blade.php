@layout('laradev::layout.main')

@section('content')

<h2>Manage Books</h2>
<p>A simple book management app.</p>
<hr/>
@if ($book)
<h3>Update Book Form</h3>
	@if(Session::has('errors'))
		<div class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('title', ':message<br/>') }} 
		{{ $errors->first('author', ':message<br/>') }}
		{{ $errors->first('published', ':message<br/>') }}
		</div>
	@endif
	{{ Form::open('laradev/book/update') }}
		{{ Form::hidden('id', $book->id) }}
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', $book->title) }}
		{{ Form::label('author', 'Author') }}
		{{ Form::text('author', $book->author) }}
		{{ Form::label('published', 'Date Published') }}
		{{ Form::text('published', $book->published, array('placeholder' => 'yy-mm-dd')) }}
		<p>{{ Form::submit('Update Book', array('class' => 'btn btn-primary')) }} or {{ HTML::link('laradev/book', 'Cancel') }} </p>
	{{ Form::close() }}
@else
<h3>New Book Form</h3>
	@if(Session::has('errors'))
		<div class="alert alert-error">
		<button class="close" data-dismiss="alert">×</button>
		{{ $errors->first('title', ':message<br/>') }} 
		{{ $errors->first('author', ':message<br/>') }}
		{{ $errors->first('published', ':message<br/>') }}
		</div>
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
		<td> <a href="{{ action('Laradev::book@index', array($book->id)) }}" alt="edit" title="edit"><i class="icon-edit"></i></a> | <a onclick="return confirm('Are you sure?')" href="{{ action('Laradev::book@delete', array($book->id)) }}" alt="delete" title="delete"><i class="icon-trash"></i></a> | <a href="{{ action('Laradev::book@copy', array($book->id)) }}" alt="provide" title="provide"><i class="icon-shopping-cart"></i></a></td>
	</tr>
	@empty
	<tr>
		<td td colspan="7">No book yet in the shelf.</td>
	</tr>
	@endforelse
</tbody>
</table>
{{ $books->links() }}
<hr/>
<h3>Source Code</h3>
<p>As what we are familiar with, lets work with C(Controller)in MVC. This is where we write code that communicates to our M(Model) where the business entities is being defined and display it in the V(Views). The app above is a simple book management/inventory. Take a look and try how it works!</p>
<p>To learn more on working with laravel controller visit <a href="http://laravel.com/docs/controllers" target="_blank">Laravel controller documentation</a>.</p>
<hr/>
<h4>Route</h4>
<p>It it important to know that controller must be registered in the routes file for it to be accessible via url. Most nested controller must be registered first in the routes especially when organizing controller into subfolder.</p>
<p>To register our book controller, put this in your route.php file</p>
<code>Route::controller('book')</code>
<p>Or register all controller in our application</p>
<code>Route::controller(Controller::detect())</code>
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

	public function get_index($id = '')
	{
		$books = DB::table('books')->paginate(5);
		if($id)
		{
			$book = Book::find($id);
			if( ! $book) return Response::error(500);
		}
		else $book = '';

		return View::make('book.index')
					->with('book', $book)
					->with('books', $books);
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
							->with_errors($validate)
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
							->with_errors($validate);
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
#if(Session::has('errors')
	[[ $errors->first('title', ':message') ]] 
	[[ $errors->first('author', ':message') ]]
	[[ $errors->first('published', ':message') ]]
#endif
#if ($book)
[[ Form::open('book/update') ]]
	[[ Form::hidden('id', $book->id) ]]
	[[ Form::label('title', 'Title') ]]
	[[ Form::text('title', $book->title) ]]
	[[ Form::label('author', 'Author') ]]
	[[ Form::text('author', $book->author) ]]
	[[ Form::label('published', 'Date Published') ]]
	[[ Form::text('published', $book->published, array('placeholder' => 'yy-mm-dd')) ]]
	[[ Form::submit('Update Book', array('class' => 'btn btn-primary')) ]] or [[ HTML::link('book', 'Cancel') ]]
[[ Form::close() ]]
#else 
[[ Form::open('book/new') ]]
	[[ Form::label('title', 'Title') ]]
	[[ Form::text('title', Input::old('title')) ]]
	[[ Form::label('author', 'Author') ]]
	[[ Form::text('author', Input::old('author')) ]]
	[[ Form::label('published', 'Date Published') ]]
	[[ Form::text('published', Input::old('published'), array('placeholder' => 'yy-mm-dd')) ]]
	[[ Form::submit('Submit Book') ]] 
[[ Form::close() ]]
#endif

List of Books
ID | Title | Author | Published | Created At | Updated At | Action
  	#forelse($books->results as $book)
		[[ $book->id ]] [[ $book->title ]] | [[ $book->author ]] | [[ $book->published ]] |
		[[ $book->created_at ]] | [[ $user->updated_at ]]
		[[ HTML::link('book/'.$book->id, 'Edit') ]] | 
		(html < a tag) href="[[ action('book@delete', array($book->id)) ]]" onclick="return confirm('Are you sure?')">delete(html > a tag)
		(html < a tag) href="[[ action('book@copy', array($book->id)) ]]">provide(html > a tag)
	#empty
		No data found.
	#endforels
	[[ $books->links() ]]
</pre>

@endsection