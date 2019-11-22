<?php

namespace Controllers;

/**
 * Classe abstraite Controller
 * Fournit des services commun pour les autres classes controllers dérivées
 */
Abstract class Controller
{

    protected $twig;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem('../views');
        $this->twig = new \Twig_Environment($loader, [

            'cache' => false, //'.\tmp',
            'auto_reload' => true,

        ]);
        
        /**
         * fonction twig pour réécrit l'url
         */
        $url = new \Twig_SimpleFunction('url', function($url, $args = null) {
           return $this->url($url, $args);
        });

        /**
         * fonction twig pour message flash
         */
        $flash = new \Twig_SimpleFunction('flash', function(){

            if(isset($_SESSION['flash'])){
                $texte =  '<div class="my-4 alert alert-'. $_SESSION['flash_type'] .'">'. $_SESSION['flash'] . '</div>';
                unset($_SESSION['flash']);
                return $texte;
            }

        });

        /**
         * fonction twig qui retourne true si l'utilisateur est connecter
         */
        $auth = new \Twig_SimpleFunction('auth', function(){

            if(isset($_SESSION['login'])){
                return true;
            }
            else{
                return false;
            }

        });

        $isAdmin = new \Twig_SimpleFunction('isAdmin', function(){

            if(isset($_SESSION['user_type']))
            {
                if($_SESSION['user_type'] == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }

        });

        $this->twig->addFunction($auth);
        $this->twig->addFunction($flash);
        $this->twig->addFunction($url);
        $this->twig->addFunction($isAdmin);
    }
    

    /**
     * @param string $twigFile Nom de la page html
     * @param array $parameters Tableau de données à transmettre a la page
     */
    protected function render(string $twigFile, array $parameters = null)
    {

        try {
            if($parameters != null)
                echo $this->twig->render($twigFile, $parameters);
            else
                echo $this->twig->render($twigFile);
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
        return true;
    }

    protected function url($url, $args = null) 
    {
        $path = getenv('ENV_URL').'/'.$url;

        if($args !== null) {
            if(is_array($args)) {
                if(substr($url, -1) != '/')
                    $path .= '/';
                foreach($args as $arg)
                {
                    $path .= $arg;
                    $path .= '/';
                }
            } else {
                throw new \InvalidArgumentException("args is not array");
            }
        }

        return $path;
    }
       

   protected function flashError($message){
        $_SESSION['flash'] = $message;
        $_SESSION['flash_type'] = 'error';
   }

   protected function flashSuccess($message){
        $_SESSION['flash'] = $message;
        $_SESSION['flash_type'] = 'success';
   }




}