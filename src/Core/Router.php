<?php

namespace Tm\Admin\Core;
use FastRoute;
use DI;
use PDO;
use Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;
use Tm\Admin\Controllers\LoginController;
use Tm\Admin\Controllers\UserController;

class Router {

    public static function run() {

        $builder = new DI\ContainerBuilder();
        $builder->addDefinitions([
            Engine::class => function() { 
                return new Engine('src/Templates');
            },

            PDO::class => function() {
                $driver = "mysql";
                $host = "localhost:3400";
                $database_name = "project3";
                $username = "root";
                $password = "";
                $mypdo = new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
                return $mypdo;
            },

            QueryFactory::class  => function() {
                return new QueryFactory('mysql');
            },

            Auth::class => function($container) {
                return new Auth($container->get('PDO'));
            }

        ]);
        $container = $builder->build();

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/register', ['Tm\Admin\Controllers\LoginController', 'reg_form_view']);
            $r->addRoute('POST', '/register', ['Tm\Admin\Controllers\LoginController', 'registration']);
            $r->addRoute('GET', '/login', ['Tm\Admin\Controllers\LoginController', 'login_form_view']);
            $r->addRoute('POST', '/login', ['Tm\Admin\Controllers\LoginController', 'login']);
            $r->addRoute('GET', '/users', ['Tm\Admin\Controllers\UserController', 'users_form_view']);
           // $r->addRoute('GET', '/about', ['Tm\Task5\Controllers\HomeController', 'about']);
            // {id} must be a number (\d+)
           // $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
            // The /{title} suffix is optional
           // $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
        });
        
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
     
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo '405 Method Not Allowed';
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $container->call($handler, $vars);
                
                //$controller = new $handler[0];
                //зрзcall_user_func([$controller, $handler[1]], $vars);
                // $controller = new $handler[0];
                 //call_user_func([$controller, $handler[1]], $vars);
                break;
        }    
    }
}