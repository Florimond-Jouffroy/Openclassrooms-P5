<?php

namespace Controllers;

use Managers\{PostManager, CommentManager};

class PostController extends Controller implements iCRUD
{
    
    private $commentManager;
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
    }
    
    
    public function create()
    {

    }

    public function store() // Traitement du formulaire et engirestement bdd
    {

    }

    public function modify()
    {

    }

    public function update()
    {

    }

    public function show($id)
    {
        $post = $this->postManager->find($id);
        $comments = $this->commentManager->getComments($id);

        return $this->render('post.html', compact('post', 'comments'));
    }

    public function all()
    {
        $postManager = new PostManager();
        $tests = $postManager->getPosts();
        return $this->render('home.html', ['posts'=> $tests]);
    }
}