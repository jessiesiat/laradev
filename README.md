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

Tables in laradev are prefix with 'laradev', i.e. 'laradev_books', 'laradev_users' and 'laradev_book_user' table.

First create a migration table to store the changes made in the db.
run `php artisan migrate:install`

To install laradev tables, run this in your command line
`php artisan migrate laradev`

### Assets

Publish laradev asset to the your public working directory

run `php artisan bundle::publish`

--

Append `laradev` to the url of `yourapp`
`http://yourapp/laradev`

And login with the default user/password.
`Username: juan@ph.ph`
`Password: juan123`

--

License under MIT license.

---