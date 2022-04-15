<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Datatables\core\Datatable;

/**
 * Load .env file
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config/');
$dotenv->load();

/**
 * Simple example
 */
$table = "user";
$columns = ["id", "firstname", "lastname", "company", "address", "city", "email", "phone"];

echo Datatable::getDatatable($table, $columns);

/**
 * Example with JOIN
 */
$table = "user LEFT JOIN city ON user.zip = city.zip";
$columns = ["user.id", "firstname", "lastname", "company", "address", "city.name", "email", "phone"];

//echo Datatable::getDatatable($table, $columns);

/**
 * Example with WHERE
 */
$table = "user";
$columns = ["id", "firstname", "lastname", "company", "address", "city", "email", "phone"];

$condition =     [
    'key' => 'id',
    'operator' => '=',
    'value' => 1
];

//echo Datatable::getDatatable($table, $columns, $condition);