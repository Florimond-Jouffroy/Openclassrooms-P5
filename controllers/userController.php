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
        $user = $this->userManager->getUserById($id);
        return $this->render('gestionUsersUpdate.html', ['user'=> $user]);
    }

    public function updateUserType($id)
    {
        $user = $this->userManager->getUserById($id);
        if($user->user_type() == 0)
        {
            $user->setUser_type(1);
        }
        else
        {
            $user->setUser_type(0);
        }

        $this->userManager->update($user);

        $_SESSION['flash'] = 'Utilisateur Modifier.';
        $_SESSION['flash_type'] = 'success';

        
        header('location: '.$this->url('gestionUsers'));
        exit;

    }

    public function update($id)
    {
        // On récupére les valeur du formulaire
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        
        //on récupére l'utilisateur enregistrer en base lié a l'id
        $user = $this->userManager->getUserById($id);

        if($firstname == ''|| $lastname == '' || $email == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';

            header('location: '.$this->url('gestionUsers/update',$user->id()));
            exit;
        }
        // on vérifie que si l'email a changer que la nouvelle est bien libre
        elseif($email != $user->email() && $this->userManager->getUserByLogin($email) != false) 
        {
            $_SESSION['flash'] = 'Email déjà utiliser par un utilisateur!';
            $_SESSION['flash_type'] = 'danger';

            header('location: '.$this->url('gestionUsers/update',$user->id()));
            exit;
        }
        else
        {
            // on met a jour les variable de l'utilisateur
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);

            $this->userManager->update($user);

            $_SESSION['flash'] = 'Utilisateur Modifier.';
            $_SESSION['flash_type'] = 'success';

            
            header('location: '.$this->url('gestionUsersShow', [$user->id()]));
            exit;
        }

    }

    public function delete($id)
    {
        $this->userManager->delete($id);

        $_SESSION['flash'] = 'Utilisateur Supprimer.';
        $_SESSION['flash_type'] = 'success';

            
        header('location: '.$this->url('gestionUsers'));
        exit;
    }

    public function show($id)
    {
        $user = $this->userManager->getUserById($id);
        return $this->render('gestionUsersShow.html', ['user'=> $user]);
    }

    public function all()
    {
        $users = $this->userManager->getUsers();
        return $this->render('gestionUsers.html', ['users'=> $users]);
    }
}