<?php 

namespace Controllers;

use Managers\PostManager;
use App\Session;

class HomeController extends Controller 
{
    

    public function home()
    {
        
        
        return $this->render('home.html');
    }

    /*
    public function post($id){

        $postManager = new PostManager();
        $post = $postManager->find($id);
        return $this->render('post.html', ['post'=>$post]);
    }
    */
    
}