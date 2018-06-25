<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 18/06/24
 * Time: 12:56
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
$DATABASE_URL = parse_url(getenv("DATABASE_URL"));

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => $DATABASE_URL["host"],
    'port' => $DATABASE_URL["port"],
    'database' => ltrim($DATABASE_URL["path"], "/"),
    'username' => $DATABASE_URL["user"],
    'password' => $DATABASE_URL["pass"],
    'charset' => 'utf8',
    'prefix' => '',
    'schema' => 'public',
    'sslmode' => 'require',
]);

// Set the event dispatcher used by Eloquent models... (optional)
/*use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));*/

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();