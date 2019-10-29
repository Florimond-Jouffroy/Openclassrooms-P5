<?php

//Général
$router->get('', ['controller'=>'HomeController', 'action'=>'home']);
$router->get('home', ['controller'=>'HomeController', 'action'=>'home']);

//Post
$router->get('post/:postId',['controller'=>'PostController','action'=>'show'])->withParam('postId', '[0-9]+');
//Post + comment
$router->post('addComment',['controller'=>'CommentController', 'action'=>'store']);

//Inscription
$router->get('inscription', ['controller'=>'UserController', 'action'=>'create']);
$router->post('inscription', ['controller'=>'UserController', 'action'=>'store']);

//Connexion et Déconnexion
$router->get('login', ['controller'=>'AuthController', 'action'=>'login']);
$router->post('login', ['controller'=>'AuthController', 'action'=>'connexion']);
$router->get('deconexion', ['controller'=>'AuthController', 'action'=>'deconnexion']);

//-----------------------------------------------------------------------------------
//Admin access
$router->get('admin', ['controller'=>'AdminController', 'action'=>'index'])->withMiddleware('admin');