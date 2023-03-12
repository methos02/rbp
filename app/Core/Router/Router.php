<?php

namespace App\Core\Router;

class Router {

    private static string $url;
    private static array $routes = [];
    public static function setUrl($url): void { self::$url = $url; }

    public static function get($path, $callable): Route {
        return self::add($path, $callable, 'GET');
    }
    public static function post($path, $callable): Route {
        return self::add($path, $callable, 'POST');
    }
    private static function add($path, $callable, $method):Route {
        $route = new Route($path, $callable);
        self::$routes[$method][] = $route;
        return $route;
    }

    /** @throws RouterException */
    public static function run(){
        if(!isset(self::$routes[$_SERVER['REQUEST_METHOD']])) { throw new RouterException('REQUEST_METHOD does not exist'); }

        /** @var Route $route */
        foreach(self::$routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match(self::$url)) { $route->call(); return; }
        }

        throw new RouterException('No matching routes');
    }
}
