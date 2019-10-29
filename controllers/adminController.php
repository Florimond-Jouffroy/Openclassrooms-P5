<?php

namespace Controllers;

class AdminController extends Controller 
{




    public function index()
    {
        return $this->render('administration.html');
    }
}