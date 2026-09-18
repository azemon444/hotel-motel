<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-detect the application base — works when the app lives one level above
// the web root (standard Laravel) or directly inside it (shared hosting/cPanel).
$base = is_file(__DIR__.'/vendor/autoload.php') ? __DIR__.'/' : __DIR__.'/../';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $base.'storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $base.'vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $base.'bootstrap/app.php';

$app->handleRequest(Request::capture());