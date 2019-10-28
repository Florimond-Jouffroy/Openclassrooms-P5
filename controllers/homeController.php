<?php 

namespace Controllers;

use Managers\PostManager;

class HomeController extends Controller 
{

    public function home()
    {
        $postManager = new PostManager();

        $tests = $postManager->getPosts();
        
        return $this->render('home.html', ['posts'=> $tests]);
    }

    /*
    public function post($id){

        $postManager = new PostManager();
        $post = $postManager->find($id);
        return $this->render('post.html', ['post'=>$post]);
    }
    */
    
}