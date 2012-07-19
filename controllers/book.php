<?php

class Laradev_Book_Controller extends Base_Controller {
	
	public $restful = true;

	public function __construct()
	{
		$this->filter('before', 'auth');
	}

	public function get_index($id = '')
	{
		$books = DB::table('laradev_books')->paginate(5);
		if($id)
		{
			$book = Devbook::find($id);
			if( ! $book) return Response::error(500);
		}
		else $book = '';

		return View::make('laradev::book.index')
						->with('books', $books)
						->with('book', $book);
	}

	public function post_new()
	{
		$data = array(
				'title' => Input::get('title'),
				'author' => Input::get('author'),
				'published' => Input::get('published')
			);

		$book = new Devbook();

		if($book->validate($data))
		{
			Devbook::create($data);
			return Redirect::to_action('laradev::book@index')->with('notify', 'Successfuly posted book.');
		}

		return Redirect::to_action('laradev::book@index')
							->with('errors', $book->errors())
							->with_input();
	}

	public function post_update()
	{
		$input = Input::get();
		$book = new Devbook();

		if($book->validate($input))
		{
			$up_book = Devbook::find(Input::get('id'));
			$up_book->author = Input::get('author');
			$up_book->title = Input::get('title');
			$up_book->published = Input::get('published');

			$up_book->save();
			return Redirect::to_action('Laradev::book@index')->with('notify', 'Successfuly update book.');
		}

		return Redirect::to_action('Laradev::book@index', array(Input::get('id')))
							->with_errors('errors', $book->errors());
	}

	public function get_delete($id)
	{
		Devbook::find($id)->delete();
		return Redirect::to_action('Laradev::book@index');
	}

	public function get_copy($id = '')
	{
		if ( ! $id) return Redirect::to_action('Laradev::book@index');
		$book = Devbook::find($id);
		$users = User::all();

		return View::make('Laradev::book.copy')
							->with('book', $book)
							->with('users', $users);
	}

	public function post_copy()
	{
		echo $user_id = Input::get('user_id');
		echo Input::get('book_id');
		//$book = Devbook::find(Input::get('book_id'));
		//$book->users()->attach($user_id);

		//return Redirect::to_action('laradev::book@index');
	}

}