<?php

namespace Entities;

class Comment extends Entity
{
    private $id;
    private $content;
    private $disabled;
    private $dateCreation;
    private $userId;
    private $postId;

   
    //Getters

    public function id()
    {
        return $this->id;
    }

    public function content()
    {
        return $this->content;
    }

    public function disabled()
    {
        return $this->disabled;
    }

    public function dateCreation()
    {
        return $this->dateCreation;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function postId()
    {
        return $this->postId;
    }

    //Setters

    public function setId($id) 
    {
    	$this->id = $id;
    }

    public function setContent($content) 
    {
    	$this->content = $content;
    }

    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    public function setDateCreation($dateCreation) 
    {
    	$this->dateCreation = $dateCreation;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function setPostId($postId) 
    {
    	$this->postId = $postId;
    }
}