<?php

namespace Managers;
use PDO;

class CommentManager extends BddManager
{
    public function getComments($postId)
    {
        $req = $this->dbase->prepare('SELECT * 
                            FROM comment c
                            WHERE c.post_id = ?
                            ');
        $req->execute([$postId]);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Entities\Comment');
        return $req->fetchAll();

    }
}