<?php 

namespace Controllers;


use Managers\UserManager;
use Entities\User;


class AuthController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    /**
     * Affiche la page de connexion
     */
    public function login(){
        return $this->render('login.html');
    }

    /**
     * Permet de déconnecter l'utilisateur
     */
    public function deconnexion()
    {

        if(isset($_SESSION['login'])){
            $_SESSION = array();
            session_destroy();

            header('location: '.$this->url('home'));
        }
        else{
            header('location: '.$this->url('home'));
        }

    }

    /**
     * Récupérer les champs du formulaire de connexion et gére la connexion de l'utilisateur
     */
    public function connexion()
    {

        // récupération des champ du formulaire de connexion
        $login = $_POST['login'];
        $password = $_POST['password'];

        // création d'un utilisateur en fonction du login
        $user = $this->userManager->getUserByLogin($login);


        // vérification qu'il y a bien un utilisateur avec ce login
        if($user == false)
        {
            $_SESSION['flash'] = 'Votre login n\'est pas bon !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('login'));
        }
        
        // vérification que le mot de passe corespond bien a celui enregistrer dans la base
        if(password_verify($password, $user->password() ))
        {

            $_SESSION['login'] = true;
            $_SESSION['firstname'] = $user->firstname();
            $_SESSION['lastname'] = $user->lastname();
            $_SESSION['userId'] = $user->id();
            $_SESSION['flash'] = 'Vous êtes bien connecté';
            $_SESSION['flash_type'] = 'success';
            $_SESSION['user_type'] = $user->user_type();
            header('location: '.$this->url('home'));
            exit;
        }
        else
        {
            $_SESSION['flash'] = 'Votre mot de passe n\'est pas correct';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('login'));
            exit;
        }

    }




}