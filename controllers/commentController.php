<?php 

namespace Controllers;

use Managers\CommentManager;
use Entities\Comment;
use App\Session;
//use App\Request;

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

    public function delete($id)
    {
        $this->commentManager->delete($id);

        Session::flash('success', 'Commentaire Supprimer.');
        //header('location: '.$this->url('gestionComments'));
        $this->request->redirect($this->url('gestionComments'));
    }

    public function store() // Traitement du formulaire et engirestement bdd
    {
        $commentContent = $this->request->postComment();
        $postId = $this->request->postPostId();
        $userId = Session::get('user_id');

        if($commentContent == '' || $postId == '')
        {
            Session::flash('danger', 'Vous n\'avez pas écrit de commentaire !');
            $this->request->redirect($this->url('post/'.$postId));
            return;
        }
      
        $comment = new Comment();
        $comment->setContent($commentContent);
        $comment->setDisabled(0);
        $comment->setUser_id($userId);
        $comment->setPost_id($postId);

        $this->commentManager->create($comment);

        Session::flash('success', 'Commentaire ajouter !');
        //header('location: '.$this->url('post/'.$postId));
        $this->request->redirect($this->url('post/'.$postId));
    }

    

    public function modify($id)
    {

    }
    public function update($id){

    }

    public function disabledChange($id)
    {
        
        $comment = $this->commentManager->getCommentById($id);

        if($comment->disabled() == 0)
        {
            $comment->setDisabled(1);
        }
        else
        {
            $comment->setDisabled(0);
        }
       
        $this->commentManager->update($comment);
        Session::flash('success', 'Commentaire modifié');

       // header('location: '.$this->url('gestionPostsShow').'/'.$comment->post_id());
        //header('location: '.$this->url('gestionPostsShow', [$comment->post_id()]));
        $this->request->redirect($this->url('gestionPostsShow', [$comment->post_id()]));

    }

    

    public function updateTest($id)
    {
        
        $error = 0;
        $error_msg = "";
        
        $comment = $this->commentManager->getCommentById($id);
        $content = $this->request->postContent();
        $disabled = $this->request->postDisabled();
        if(empty($content)  && mb_strlen($content) < 3)
        {
           $error++;
           $error_msg .= "Le contenu fait moins de 3 caractères";
        }

        if($error == 0) {
            $comment->setContent($content);
            $comment->setDisabled($disabled);
            
            $this->commentManager->update($comment);

            Session::flash('success', 'Commentaire Modifier.');

        } else {
            Session::flash('danger', $error_msg);
        }
        //header('location: '.$this->url('gestionPosts'));
        $this->request->redirect($this->url('gestionPosts'));
    }

    public function show($id)
    {
      
    }

    public function all()
    {
        $comments = $this->commentManager->getComments();
        return $this->render('gestionComments.html', ['comments'=> $comments]);
    }

}