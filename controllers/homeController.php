<?php 

namespace Controllers;

use Managers\PostManager;
use App\Session;

class HomeController extends Controller 
{
    

    public function home()
    {
        $postManager = new PostManager();
        $posts = $postManager->getLastPosts();
        return $this->render('home.html', ['posts'=> $posts]);
    }
    
   public function message()
   {
       $email = $_POST['email'];
       $message = $_POST['message'];
       
        if($email == '' || $message == '')
        {    
            Session::flash('danger', 'Vous n\'avez pas bien remplie le formulaire !');
            //header('location: '.$this->url('home'));
            $this->request->redirect($this->url('home'));
            return;
        }

        $message = wordwrap($message, 70, "\r\n");
        $entetes = "Reply-to : .'$email'.\n";
       
        $to      = 'florimond.jouffroy@gmail.com';
        $subject = 'Contact depuis site web';
        $headers = 'From:'.$email . "\r\n" .
        'Reply-To: florimond.jouffroy@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

       

       if(!mail($to, $subject, $message, $headers)){
            Session::flash('danger', 'Message non envoyer !');
            //header('location: '.$this->url('home'));
            $this->request->redirect($this->url('home'));
        }
        else{
            Session::flash('success', 'Message envoyer !');
            //header('location: '.$this->url('home'));
            $this->request->redirect($this->url('home'));
        }
       
       
   }
    
    
}