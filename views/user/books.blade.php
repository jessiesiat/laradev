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
@endsection
