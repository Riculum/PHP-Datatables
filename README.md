# PHP-Datatables
Simple PHP extension for [Datatables](http://datatables.net)

## Installation
Use the package manager [composer](https://getcomposer.org) to install the library
```bash
composer require riculum/php-datatables
```

## Initial setup

### Credentials
The basic database settings can be set through environment variables. Add a `.env` file in the root of your project. Make sure the `.env` file is added to your `.gitignore` so it is not checked-in the code. By default, the library looks for the following variables:

* DB_HOST
* DB_NAME
* DB_USERNAME
* DB_PASSWORD

More information how to use environment variables [here](https://github.com/vlucas/phpdotenv)

### Configuration
Import vendor/autoload.php and load the `.env` settings
```php
require_once 'vendor/autoload.php';

use Database\Core\Database as DB;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
```

## Datatables

### BASIC
To get the properly formatted data, you just need to define the table and columns
```php
$table = "user";
$columns = ["id", "firstname", "lastname", "company", "address", "city", "email", "phone"];

echo Datatable::getDatatable($table, $columns);
```

### JOIN
To combine multiple tables with related columns, use the SQL `JOIN` statement
```php
$table = "user JOIN city ON user.zip = city.zip";
$columns = ["user.id", "firstname", "lastname", "company", "address", "city.name", "email", "phone"];

echo Datatable::getDatatable($table, $columns);
```
Notice to specify the columns with table names

### WHERE
Use the `WHERE` clause to extract with priority only those records that meet a certain condition
```php
$table = "user";
$columns = ["id", "firstname", "lastname", "company", "address", "city", "email", "phone"];

$where =     [
    'key' => 'id',
    'operator' => '=',
    'value' => 1
];

echo Datatable::getDatatable($table, $columns, $where);
```

## Bugreport & Contribution
If you find a bug, please either create a ticket in github, or initiate a pull request

## Versioning
We adhere to semantic (major.minor.patch) versioning (https://semver.org/). This means that:

* Patch (x.x.patch) versions fix bugs
* Minor (x.minor.x) versions introduce new, backwards compatible features or improve existing code.
* Major (major.x.x) versions introduce radical changes which are not backwards compatible.

In your automation or procedure you can always safely update patch & minor versions without the risk of your application failing.
