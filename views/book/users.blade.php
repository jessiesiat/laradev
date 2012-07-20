@layout('laradev::layout.main')

@section('content')
<h3>Users with book: <em>{{ $book->title }}</em></h3>
<hr/>
<ul>
@forelse ($pivot->get() as $pivot)
	<li>{{ '<b>'.User::find($pivot->user_id)->name.'</b> <em>('.HTML::mailto(User::find($pivot->user_id)->email).')</em>' }}</li>
@empty
	<p>No user owe this book</p>
@endforelse
</ul>
<hr/>
<h4>Source Code</h4>
<p>Here we are using using Eloquent <code>pivot</code> method to retrieve data in our pivot table(book_user).</p>
<h4>Controller<h4>
<pre class="prettyprint linenums">
//application\controllers\book.php
public function get_bookUsers($book_id = '')
{
	if( ! $book_id) return Redirect::back();
	$book = Book::find($book_id);
	$pivot = $book->users()->pivot();
	return View::make('book.users')
				 ->with('book', $book)
				 ->with('pivot', $pivot);
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
//application\views\book\users.php
Users with book: [[ $book->title ]
#forelse ($pivot->get() as $pivot)
	[[ User::find($pivot->user_id)->name.' ('.HTML::mailto(User::find($pivot->user_id)->email).')' ]]
#empty
	No user has this book
#endforelse
</pre>
@endsection
