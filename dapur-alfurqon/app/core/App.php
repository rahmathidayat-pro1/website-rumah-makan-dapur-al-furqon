<?php

class App {
    protected $controller = 'Home'; // Default controller
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // Special routing for /gallery (public) - maps to Gallery_public controller
        if( isset($url[0]) && strtolower($url[0]) == 'gallery' ) {
            $this->controller = 'Gallery_public';
            unset($url[0]);
            
            require_once 'app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;
            
            // Method
            if( isset($url[1]) ) {
                if( method_exists($this->controller, $url[1]) ) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
            
            // Params
            if( !empty($url) ) {
                $this->params = array_values($url);
            }
            
            call_user_func_array([$this->controller, $this->method], $this->params);
            return;
        }

        // Controller
        if( isset($url[0]) ) {
            if( file_exists('app/controllers/' . ucfirst($url[0]) . '.php') ) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Method
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Params
        if( !empty($url) ) {
            $this->params = array_values($url);
        }

        // Run controller & method, and send params if any
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if( isset($_GET['url']) ) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
