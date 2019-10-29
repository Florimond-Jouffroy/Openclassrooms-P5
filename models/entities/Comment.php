<?php

namespace Entities;

class Comment extends Entity
{
    private $id;
    private $content;
    private $disabled;
    private $dateCreation;
    private $user_id;
    private $post_id;

   
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

    public function user_id()
    {
        return $this->user_id;
    }

    public function post_id()
    {
        return $this->post_id;
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

    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }

    public function setPost_id($post_id) 
    {
    	$this->post_id = $post_id;
    }
}