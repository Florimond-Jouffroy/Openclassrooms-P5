<?php

namespace Managers;

use Entities\Post;
use Entities\User;
use PDO;

class PostManager extends BddManager
{
    
    public function getPostsWithAuteur()
    {
        $req = $this->dbase->prepare('SELECT * FROM post p INNER JOIN user u ON p.user_id = u.id');
        $req->execute();
        
        $posts = [];
        while( ($row = $req->fetch(PDO::FETCH_ASSOC)) !== false)
        {
            $user = new User([
                'id'=>$row['user_id'],
                'firstname'=>$row['firstname'],
                'lastname'=>$row['lastname'],
                'email'=>$row['email'],
                'user_type'=>$row['user_type']
            ]);

            $post = new Post([
                'id'=>$row['id'],
                'title'=>$row['title'],
                'chapo'=>$row['chapo'],
                'content'=>$row['content'],
                'dateCreation'=>$row['date_creation'],
                'dateUpdate'=>$row['date_update'],
                'user'=>$user,
            ]);

            $posts[] = $post;
        }

        return $posts;
    }


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