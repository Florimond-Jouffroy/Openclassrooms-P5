<?php

namespace Entities;

class Post extends Entity
{
    private $id;
    private $title;
    private $chapo;
    private $content; 
    private $dateCreation;
    private $dateUpdate;
    private $userId;
  


    /**
     * -- Getters --
     */

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function chapo()
    {
        return $this->chapo;
    }
    
    public function content()
    {
        return $this->content;
    }

    public function dateCreation()
    {
        return $this->dateCreation;
    }

    public function dateUpdate()
    {
        return $this->dateUpdate;
    }

    public function userId()
    {
        return $this->userId;
    }
    

    /**
     * -- Setters --
     */

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

}