<?php

namespace Controllers;

use Managers\{PostManager, CommentManager, UserManager};
use Entities\Post;


class PostController extends Controller implements iCRUD
{
    
    private $commentManager;
    private $postManager;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
    }
    
    
    public function create()
    {
        return $this->render('gestionPostsNew.html');
    }

    public function store() // Traitement du formulaire et engirestement bdd
    {
        $title = $_POST['title'];
        $chapo = $_POST['chapo'];
        $content = $_POST['content'];
        $user_id = $_SESSION['userId'];

        if($title == '' || $chapo == '' || $content == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';
            header('location: '.$this->url('gestionPosts'));
            exit;
        }
        else
        {
            $post = new Post($_POST);
            $post->setUser_id($user_id);

            $this->postManager->create($post);

            $_SESSION['flash'] = 'Article ajouter.';
            $_SESSION['flash_type'] = 'success';

            
            header('location: '.$this->url('gestionPosts'));
            exit;
        }
    }

    public function delete($id)
    {
        $this->commentManager->deleteByPostId($id); // suppression des commentaires lié au post
        $this->postManager->delete($id); // suppression du post

        $_SESSION['flash'] = 'Article supprimer.';
        $_SESSION['flash_type'] = 'success';

            
        header('location: '.$this->url('gestionPosts'));
        exit;
    }

    public function modify($id)
    {
        $post = $this->postManager->getPostById($id);
        return $this->render('gestionPostsUpdate.html', ['post'=> $post]);
    }

    public function update($id)
    {
        $title = $_POST['title'];
        $chapo = $_POST['chapo'];
        $content = $_POST['content'];
        $user_id = $_SESSION['userId'];
        
        if($title == ''|| $chapo == '' || $content == '')
        {
            $_SESSION['flash'] = 'Vous n\'avez pas bien remplie le formulaire !';
            $_SESSION['flash_type'] = 'danger';

            header('location: '.$this->url('gestionPosts'));
            exit;
        }
        else
        {
            $post = $this->postManager->getPostById($id);
            
            $post->setTitle($title);
            $post->setChapo($chapo);
            $post->setContent($content);
            $post->setUser_id($user_id);

            $this->postManager->update($post);

            $_SESSION['flash'] = 'Article Modifier.';
            $_SESSION['flash_type'] = 'success';

            header('location: '.$this->url('gestionPosts'));
            exit;
        }
    }

    public function show($id)
    {
        $post = $this->postManager->getPostById($id);
        $user = $this->userManager->getUserById($post->user_id());
        $comments = $this->commentManager->getCommentsByPostTest($id);
        return $this->render('post.html', compact('post','user','comments'));
    }

    
    public function showAdmin($id)
    {
        $post = $this->postManager->getPostById($id);
        $user = $this->userManager->getUserById($post->user_id());
        $comments = $this->commentManager->getCommentsByPostTest($id);

        return $this->render('gestionPostsShow.html', compact('post','user','comments'));
    }

    public function all()
    {
        
        $posts = $this->postManager->getPosts();
        return $this->render('home.html', ['posts'=> $posts]);
    }


    public function allAdmin()
    {
        $posts = $this->postManager->getPostsWithAuteur();
        return $this->render('gestionPosts.html', ['posts'=> $posts]);
    }
}