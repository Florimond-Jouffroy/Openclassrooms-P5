<?php

namespace Controllers;

use Managers\UserManager;
use Entities\User;

class UserController extends Controller implements iCRUD
{

    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();

    }

    public function create()
    {
        return $this->render('registration.html');
    }

    public function store() // Traitement du formulaire et engirestement bdd
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordv = $_POST['passwordv'];


        // vérification que l email est un email et vérification firstname lastname caractere alphanumérique

        if($firstname == ''|| $lastname == '' || $email == '' || $password == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('inscription'));
            exit;
        }
        elseif($this->userManager->getUserByLogin($email) != false)
        {
            $_SESSION['flash'] = 'Cette email est déjà utiliser !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('inscription'));
            exit;
        }
        elseif($password != $passwordv)
        {
            flashError('Password à vérifier !');
            header('location: '.$this->url('inscription'));
            exit;
        }
        else
        {

            $user = new User($_POST);

            $user->hashPassword();

            $this->userManager->create($user);
            
            // conneceter directement l'utilisateur et création de variable de session
            $_SESSION['login'] = true;
            $_SESSION['firstname'] = $user->firstname();
            $_SESSION['lastname'] = $user->lastname();
            $_SESSION['userId'] = $user->id();
            $_SESSION['flash'] = 'Vous êtes bien connecté';
            $_SESSION['flash_type'] = 'success';

            
            header('location: '.$this->url('home'));
            exit;
        }
    }

    public function modify($id)
    {

    }

    public function update($id)
    {

    }

    public function show($id)
    {
      
    }

    public function all()
    {
        
        $users = $this->userManager->getUsers();
        return $this->render('gestionUsers.html', ['users'=> $users]);
    }
}