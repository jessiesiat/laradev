# Laradev ~ A working bundle for learning Laravel PHP framework

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

To create the table, run this in your command line
`php artisan migrate:install laradev`

### Auth

Laradev uses the default auth class built within laravel.
	- 'table' => 'users'
	- 'model' => 'User'
	- etc. 

Visit `http://myapp/laradev` and login with the default user/password.
Username: juan@ph.ph
Password: juan123

---

Thats it for now and I hope you will learn from it, begginers...

