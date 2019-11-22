<?php 

namespace Controllers;

use Managers\PostManager;

class BlogController extends Controller 
{
    

    public function home()
    {
        $postManager = new PostManager();

        $posts = $postManager->getPosts();
        
        return $this->render('blog.html', ['posts'=> $posts]);
    }

   
    
}