<?php

namespace Managers;

use Entities\User;
use PDO;

class UserManager extends BddManager
{
    public function create(User $user) : void
    {
        $req = $this->dbase->prepare('INSERT INTO user (firstname, lastname, email, password, date_creation) VALUES (?, ?, ?, ?, NOW())');
        $req->execute([$user->firstname(), $user->lastname(), $user->email(), $user->password()]);

    }

    public function connexion(){
        
    }

    public function getUserByLogin($login)
    {

        $req = $this->dbase->prepare('SELECT * FROM user WHERE user.email = ?');
        $req->execute([$login]);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Entities\User');
        return $req->fetch();    
    }

}