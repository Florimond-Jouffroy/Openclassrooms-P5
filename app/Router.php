<?php

namespace App;

use App\Route;

class Router
{
    private $action;
    private $routes = [];


    public function __construct()
    {
        $this->action = $action;
    }

    public function get($path, $controller)
    {
        return $this->add($path, $controller, 'GET');
    }

    public function post($path, $controller)
    {
        return $this->add($path, $controller, 'POST');
    }

    public function add($path, $controller, $method)
    {
        $route = new Route($path, $controller);
        $this->routes[$method][] = $route;
        return $route;
    }

    public function run()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
        {
            throw new Exception('REQUEST method isn\'t correct');
        }

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
        {
            if($route->match($this->action))
            {
                return $route->call();
            }
        }
        
        echo '404';
        exit;
    }
}