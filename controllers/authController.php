<?php 

namespace Controllers;


use Managers\UserManager;
use Entities\User;


class AuthController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    




}