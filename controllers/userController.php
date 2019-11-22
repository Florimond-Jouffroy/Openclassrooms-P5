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
            Session::flash('danger', 'Vous n\'avez pas bien remplie le formulaire !');
            header('location: '.$this->url('inscription'));
            return;
        }
        elseif($this->userManager->getUserByLogin($email) != false)
        {
            Session::flash('danger', 'Cette email est déjà utiliser !');
            header('location: '.$this->url('inscription'));
            return;
        }
        elseif($password != $passwordv)
        {
            Session::flash('danger', 'Password à vérifier !');
            header('location: '.$this->url('inscription'));
            return;
        }
        else
        {
            $user = new User($_POST);
            $user->hashPassword();
            $this->userManager->create($user);
            
            // Conneceter directement l'utilisateur et création des variables de session
            Session::put('login', true);
            Session::put('firstname', $user->firstname());
            Session::put('lastname', $user->lastname());
            Session::put('userId', $user->id());
            Session::flash('success', 'Vous êtes bien connecté');
            header('location: '.$this->url('home'));
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

        Session::flash('success', 'Utilisateur Modifier.');
        header('location: '.$this->url('gestionUsers'));
    }

    public function update($id)
    {
        // On récupére les valeur du formulaire
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        
        // On récupére l'utilisateur enregistrer en base lié a l'id
        $user = $this->userManager->getUserById($id);

        if($firstname == ''|| $lastname == '' || $email == '')
        {
            Session::flash('danger', 'Vous n\'avez pas bien remplie le formulaire !');
            header('location: '.$this->url('gestionUsers/update',$user->id()));
            return;
        }
        // On vérifie que si l'email a changer que la nouvelle est bien libre
        elseif($email != $user->email() && $this->userManager->getUserByLogin($email) != false) 
        {
            Session::flash('danger', 'Email déjà utiliser par un utilisateur!');
            header('location: '.$this->url('gestionUsers/update',$user->id()));
            return;
        }
        else
        {
            // On met a jour les variable de l'utilisateur
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);

            $this->userManager->update($user);

            Session::flash('success', 'Utilisateur Modifier.');
            header('location: '.$this->url('gestionUsersShow', [$user->id()]));
        }

    }

    public function delete($id)
    {
        $this->userManager->delete($id);
        Session::flash('success', 'Utilisateur Supprimer.');
        header('location: '.$this->url('gestionUsers'));
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