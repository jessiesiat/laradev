@layout('laradev::layout.main')

@section('content')
<h3>Books own by <em>{{ $user->name }}</em></h3>
<hr/>
<ul>
@forelse ($pivot->get() as $pivot)
	<li>{{ '<b><a href="'.action('laradev::book@bookUsers', array($pivot->devbook_id)).'">'.Devbook::find($pivot->devbook_id)->title.'</a></b> - author: <em>'.Devbook::find($pivot->devbook_id)->author.'</em>' }}</li>
@empty
	<p>No book owned</p>
@endforelse
</ul>
<hr/>
<h3>Source Code</h3>
<p>Here we are using using Eloquent <code>pivot</code> method to retrieve data in our pivot table(book_user).</p>
<b>Route</b>
<pre class="prettyprint linenums">
//application\routes.php
Route::get('(:num)/books', function($user_id){
	$user = User::find($user_id);
	$pivot = $user->books()->pivot();
	return View::make('laradev::user.books')
					->with('user', $user)
					->with('pivot', $pivot);
});
</pre>
<b>Model<b>
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
<b>View</b>
<pre class="prettyprint linenums">
Books own by [[ $user->name ]]
#forelse ($pivot->get() as $pivot)
	[[ Book::find($pivot->book_id)->title.' - author: '.Devbook::find($pivot->book_id)->author ]]
#empty
	No book owned
#endforelse
</pre>
@endsection
