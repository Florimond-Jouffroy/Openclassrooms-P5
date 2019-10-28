<?php

namespace Managers;

use PDO;

class PostManager extends BddManager
{
    

    public function getPosts()
    {
        $req = $this->dbase->prepare('SELECT * 
                            FROM post 
                            ');
        $req->execute();
 
        $req->setFetchMode(PDO::FETCH_CLASS, 'Entities\Post');
        return $req->fetchAll();
    }

    public function find($id)
    {
        $req = $this->dbase->prepare('SELECT * 
        FROM post 
        WHERE id = ?');
        $req->execute([$id]);

        $req->setFetchMode(PDO::FETCH_CLASS, 'Entities\Post');
        return $req->fetch();    
    }

    /*
    public function getPosts()
    {
        $req = $this->dbase->prepare('SELECT *
                            FROM post
                            ');
        $req->execute();
        $rows = array();
        while($row = $req->fetchAll(PDO::FETCH_ASSOC)){
            $rows[] = new Post($row);
        }

        return $rows;
    }
    */
}