@layout('layout.main')

@section('content')

			@foreach ($posts->results as $post)
				<h2> {{ HTML::link('view/'.$post->id, $post->title) }} </h3>

				<p>
					{{ substr($post->body, 0, 120).'[..]' }}
				</p>
				<p> {{ HTML::link('view/'.$post->id, 'Read more &rarr;') }} </p>
			@endforeach
			<p> {{ $posts->links() }} </p>
			
@endsection
