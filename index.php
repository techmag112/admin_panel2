<?php declare(strict_types=1);

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Start a Session
if( !session_id() ) {
    session_start();
}

// Initialize Composer Autoload
require_once 'vendor/autoload.php';

//use Tm\Admin\App\QueryBuilder;

//$query = new QueryBuilder();

// // Create new Plates instance

//$templates = new League\Plates\Engine('./src/templates');

// // // Render a template

//echo $templates->render('login', ['message' => 'Test Test Test Test Test Test', 'type' => 'error']);

use Tm\Admin\Core\Router;
Router::run();