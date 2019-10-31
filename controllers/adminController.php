<?php

namespace Controllers;

use Managers\UserManager;
use Entities\User;

class AdminController extends Controller 
{

    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();

    }


    public function index()
    {
        return $this->render('administration.html');
    }

    public function gestionPosts()
    {
        return $this->render('gestionPosts.html');
    }

    public function gestionComments()
    {
        return $this->render('gestionComments.html');
    }

    public function gestionUsers()
    {
        return $this->render('gestionUsers.html');
    }

    public function modifyUser($id)
    {
        $user = $this->userManager->getUserById($id);
        return $this->render('gestionUsersUpdate.html', ['user'=> $user]);
    }


    public function deleteUser($id)
    {
        $this->userManager->delete($id);

        $_SESSION['flash'] = 'Utilisateur Supprimer.';
        $_SESSION['flash_type'] = 'success';

            
        header('location: '.$this->url('gestionUsers'));
        exit;
    }


    public function updateUser($id)
    {

        

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        

        //Attention voir avec Antoine pour la redirection
        if($firstname == ''|| $lastname == '' || $email == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('gestionUsers'));
            exit;
        }
        elseif($email != $oldUser->email() && $this->userManager->getUserByLogin($email) != false)
        {
           
            $_SESSION['flash'] = 'Email déjà utiliser par un utilisateur!';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('gestionUsers'));
            exit;
            
        }
        else
        {
            $user = $this->userManager->getUserById($id);
            
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setUser_type($user_type);

            $this->userManager->update($user);

            $_SESSION['flash'] = 'Utilisateur Modifier.';
            $_SESSION['flash_type'] = 'success';

            
            header('location: '.$this->url('gestionUsers'));
            exit;
        }

    }

    public function storeUser()
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        $password = $_POST['password'];
       

        if($firstname == ''|| $lastname == '' || $email == '' || $password == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('gestionUsers'));
            exit;
        }
        elseif($this->userManager->getUserByLogin($email) != false)
        {
            $_SESSION['flash'] = 'Cette email est déjà utiliser !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('gestionUsers'));
            exit;
        }
        else
        {

            $user = new User($_POST);
            $user->setUser_type($user_type);
            

            $user->hashPassword();

            $this->userManager->create($user);
            
            // conneceter directement l'utilisateur et création de variable de session
            
            $_SESSION['flash'] = 'Utilisateur ajouter.';
            $_SESSION['flash_type'] = 'success';

            
            header('location: '.$this->url('gestionUsers'));
            exit;
        }

        
    }












}