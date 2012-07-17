# Laradev

Its a learning bundle for Laravel given the source code and how it works in the actual world.

## Installation

Create a folder 'laradev' in the 'bundles' directory of your installation

`bundles/laradev`

Download and extract the source in the it.

## How it is handled

Add this to your 'bundles.php' array
` 'laradev' => array('handles' => 'laradev') `

## Things to consider

### Migration

Tables in laradev are prefix with 'laradev', i.e. 'laradev_books', etc. except for 'users' table.
Make sure you dont have a table 'users' that already exists!

First create a migration table to store changes made in the db.
run `php artisan migrate:install`

To create the tables, run this in your command line
`php artisan migrate laradev`

### Auth

Laradev uses the default auth class built within laravel.
	- 'table' => 'users'
	- 'model' => 'User'
	- etc. 
*So dont create a 'User' model in your application directory, it will just break my code at this point. I'll see what I can do to handle it!

### Assets

Publish laradev asset to your public directory

run `php artisan bundle::publish`

--

Thats it! 
Now visit `http://yourapp/laradev` and login with the default user/password.
Username: juan@ph.ph
Password: juan123

---

Thats it for now and I hope you will learn from it.

