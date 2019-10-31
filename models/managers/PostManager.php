<?php

namespace Managers;

use Entities\Post;
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

    // trouve un article par sont id
    public function getPostById($id)
    {
        $req = $this->dbase->prepare('SELECT * 
        FROM post 
        WHERE id = ?');
        $req->execute([$id]);

        $req->setFetchMode(PDO::FETCH_CLASS, 'Entities\Post');
        return $req->fetch();    
    }

    // création d'un post 
    public function create(Post $post) : void
    {
        $req = $this->dbase->prepare('INSERT INTO post (title, chapo, content, date_creation, date_update, user_id) VALUES (?, ?, ?, NOW(), NOW(), ?)');
        $req->execute([$post->title(), $post->chapo(), $post->content(), $post->user_id()]);
    }

    // Supprime un article
    public function delete($id) :void
    {
        $req = $this->dbase->prepare('DELETE FROM post WHERE id = ?');
        $req->execute([$id]);
    }

    // Met a jour un article
    public function update(Post $post) :void
    {
        $req = $this->dbase->prepare('UPDATE post SET title = ?, chapo = ?, content = ?, date_update = NOW(), user_id = ? WHERE id = ?');
        $req->execute([$post->title(), $post->chapo(), $post->content(), $post->user_id(), $post->id()]);
    }



}