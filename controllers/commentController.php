<?php 

namespace Controllers;

use Managers\CommentManager;
use Entities\Comment;

class CommentController extends Controller implements iCRUD
{

    private $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
    }


    public function create()
    {

    }

    public function store() // Traitement du formulaire et engirestement bdd
    {
        $commentContent = $_POST['comment'];
        $postId = $_POST['postId'];
        $userId = $_SESSION['userId'];

       
        if($commentContent == '' || $postId == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas écrit de commentaire !';
            $_SESSION['flash_type'] = 'danger';
           
            return header('location: '.$this->url('post/'.$postId));
            exit;
        }
        else
        {
            $comment = new Comment();
            $comment->setContent($commentContent);
            $comment->setDisabled(0);
            $comment->setUser_id($userId);
            $comment->setPost_id($postId);

            $this->commentManager->create($comment);

            $_SESSION['flash'] = 'Commentaire ajouter !';
            $_SESSION['flash_type'] = 'success';
            return header('location: '.$this->url('post/'.$postId));
            exit;
        }
    }

    public function modify($id)
    {

    }

    public function update($id)
    {

    }

    public function show($id)
    {
      
    }

    public function all()
    {
        
    }

}