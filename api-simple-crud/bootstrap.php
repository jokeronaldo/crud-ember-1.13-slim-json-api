<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

// Dotenv (enviroment definitions)
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Slim Application
use App\App;

$app = new \App\App();

// Eloquent ORM (Laravel Database)
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

/*
 * MongoDb for Eloquent
 *
$capsule->getDatabaseManager()->extend('mongodb', function($config) {
    return new Jenssegers\Mongodb\Connection($config);
});
*/

$capsule->addConnection([
    'driver'    => getenv('DB_DRIVER'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_DATABASE'),
    'username'  => getenv('DB_USERNAME'),
    'password'  => getenv('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->bootEloquent();

// CORS Hook
$app->hook('slim.before', function () use ($app) {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: Origin, Content-Type, x-requested-with');
	header('Access-Control-Allow-Methods: PATCH, GET, POST, DELETE, OPTIONS');
	
	if($app->request->isOptions()) {
		$app->stop();
	}
}, 1);
