<?php 

namespace Controllers;

use Managers\CommentManager;
use Entities\Comment;
use App\Session;

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
        header('location: '.$this->url('gestionComments'));
    }

    public function store() // Traitement du formulaire et engirestement bdd
    {
        $commentContent = $_POST['comment'];
        $postId = $_POST['postId'];
        $userId = $_SESSION['userId'];

        if($commentContent == '' || $postId == '')
        {
            Session::flash('danger', 'Vous n\'avez pas écrit de commentaire !');
            header('location: '.$this->url('post/'.$postId));
            return;
        }
      
        $comment = new Comment();
        $comment->setContent($commentContent);
        $comment->setDisabled(0);
        $comment->setUser_id($userId);
        $comment->setPost_id($postId);

        $this->commentManager->create($comment);

        Session::flash('success', 'Commentaire ajouter !');
        header('location: '.$this->url('post/'.$postId));
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
        header('location: '.$this->url('gestionPostsShow', [$comment->post_id()]));
      

    }

    

    public function updateTest($id)
    {
        // ATTENTION A MODIFIER
        $content = null;
        $disabled = null;
        $date_creation = null;
        $user_id = null;
        $post_id = null;

        foreach($datas as $key=>$data) {
            if(!empty($data)) {
                $method = 'set'.ucfirst($key);
                $comment->$method($data);
            }
        }
        
        if(isset($_POST['content']))
        {
            $content = $_POST['content'];
        }
        if(isset($_POST['disabled']))
        {
            $disabled = $_POST['disabled'];
        }
        if(isset($_POST['date_creation']))
        {
            $date_creation = $_POST['date_creation'];
        }
        if(isset($_POST['user_id']))
        {
            $user_id = $_POST['user_id'];
        }
        if(isset($_POST['post_id']))
        {
            $post_id = $_POST['post_id'];
        }

        $comment = $this->commentManager->getCommentById($id);

        if($content != null)
        {
            $comment->setContent($content);
        }
        
        if($disabled != null)
        {
            $comment->setDisabled($disabled);
        }

        if($date_creation != null)
        {
            $comment->setDate_creation($date_creation);
        }

        if($user_id != null)
        {
            $comment->setUser_id($user_id);
        }

        if($post_id != null)
        {
            $comment->setPost_id($post_id);
        }

        $this->commentManager->update($comment);

        Session::flash('success', 'Commentaire Modifier.');
        header('location: '.$this->url('gestionPosts'));
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