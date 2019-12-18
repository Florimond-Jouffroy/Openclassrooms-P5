<?php 


require '../vendor/autoload.php';


use App\{Router, Session, Request};

Session::start();

$dotenv = \Dotenv\Dotenv::create('../');
$dotenv->load();

$action = $_GET['action'] ?? '';


$router = new Router($action);
require_once '../routes/routes.php';


$router->run();
