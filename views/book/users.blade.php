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
@endsection
