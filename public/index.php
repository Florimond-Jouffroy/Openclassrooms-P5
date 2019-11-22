<?php 


require '../vendor/autoload.php';

use App\{Router, Session};

Session::start();

$dotenv = \Dotenv\Dotenv::create('../');
$dotenv->load();

$action = $_GET['action'] ?? '';


$router = new Router($action);
require_once '../routes/routes.php';

$router->run();