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


// gestion des posts
$router->get('gestionPosts', ['controller'=>'PostController', 'action'=>'allAdmin'])->withMiddleware('admin');
$router->get('gestionPosts/new', ['controller'=>'PostController', 'action'=>'create'])->withMiddleware('admin'); // Envoie sur la page du formulaire pour ajouter un article
$router->post('gestionPosts/new', ['controller'=>'PostController', 'action'=>'store'])->withMiddleware('admin'); // retour du formulaire d'ajout d'un article
$router->get('gestionPosts/delete/:postId', ['controller'=>'PostController', 'action'=>'delete'])->withParam('postId', '[0-9]+')->withMiddleware('admin'); // Supprime un article
$router->get('gestionPosts/update/:postId', ['controller'=>'PostController', 'action'=>'modify'])->withParam('postId', '[0-9]+')->withMiddleware('admin'); // Modifier un article
$router->post('gestionPosts/update/:postId', ['controller'=>'PostController', 'action'=>'update'])->withParam('postId', '[0-9]+')->withMiddleware('admin'); 



// gestion des commentaires
$router->get('gestionComments', ['controller'=>'AdminController', 'action'=>'gestionComments'])->withMiddleware('admin');



// gestion des utilisateurs
$router->get('gestionUsers', ['controller'=>'UserController', 'action'=>'all'])->withMiddleware('admin');
$router->post('gestionUsers', ['controller'=>'AdminController', 'action'=>'storeUser'])->withMiddleware('admin'); //ajout d'un utilisateur 
$router->get('gestionUsers/update/:userId', ['controller'=>'AdminController', 'action'=>'modifyUser'])->withParam('userId', '[0-9]+')->withMiddleware('admin');
$router->post('gestionUsers/update/:userId', ['controller'=>'AdminController', 'action'=>'updateUser'])->withParam('userId', '[0-9]+')->withMiddleware('admin');
$router->get('gestionUsers/delete/:userId', ['controller'=>'AdminController', 'action'=>'deleteUser'])->withParam('userId', '[0-9]+')->withMiddleware('admin');