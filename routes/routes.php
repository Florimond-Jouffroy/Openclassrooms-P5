<?php


$router->get('', ['controller'=>'HomeController', 'action'=>'home']);
$router->get('home', ['controller'=>'HomeController', 'action'=>'home']);

$router->get('inscription', ['controller'=>'UserController', 'action'=>'create']);
$router->post('inscription', ['controller'=>'UserController', 'action'=>'store']);

$router->get('login', ['controller'=>'AuthController', 'action'=>'login']);
$router->post('login', ['controller'=>'AuthController', 'action'=>'connexion']);
$router->get('deconexion', ['controller'=>'AuthController', 'action'=>'deconexion']);

$router->get('post/:postId',['controller'=>'PostController','action'=>'show'])->withParam('postId', '[0-9]+');