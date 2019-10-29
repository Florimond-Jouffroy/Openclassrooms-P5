<?php


$router->get('', ['controller'=>'HomeController', 'action'=>'home']);
$router->get('home', ['controller'=>'HomeController', 'action'=>'home']);

$router->get('inscription', ['controller'=>'UserController', 'action'=>'create']);
$router->post('inscription', ['controller'=>'UserController', 'action'=>'store']);