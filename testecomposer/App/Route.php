<?php
namespace App;
class Route
{
    private $routes;
    public function __construct()
    {
        $this->iniRoutes();
        //$this->getUrl(); 
        $this->run($this->getUrl());
    }
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }
    public function iniRoutes()
    {
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );
        $routes['sobre_nos'] = array(
            'route' => '/sobre_nos',
            'controller' => 'SobreNosController',
            'action' => 'sobre_nos'
        );

        $this->setRoutes($routes);
    }
    public function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function run($url)
    {
        foreach ($this->routes as $key => $value) {
            if ($value['route'] == $url) {

                $class = "App\\Controller\\" . $value['controller'];
                $controller = new $class;
                echo "<br>";
                $action = $value['action'];
                $controller->$action();
            }

        }
    }




}