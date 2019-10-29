<?php

namespace Managers;

use Entities\Comment;
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


    public function create(Comment $comment) : void
    {
        $req = $this->dbase->prepare('INSERT INTO comment (content, disabled, date_creation, user_id, post_id) VALUES (?, ?, NOW(), ?, ? )');
        $req->execute([$comment->content(), $comment->disabled(), $comment->user_id(), $comment->post_id()]);
    }


}