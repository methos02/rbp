<?php

namespace App\Core\Router;

use Exception;

class Route
{
    private string $path;
    private string $controller_path;
    private array $params = [];
    private array $match_rules = [];

    public function __construct($path, $controller_path){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->controller_path = $controller_path;
    }

    public function with($param, $regexp):self {
        $this->match_rules[$param] = str_replace('(', '(?:', $regexp);
        return $this;
    }

    public function match($url): bool {
        $path = preg_replace_callback('#:(\w+)#', [$this, 'paramMatch'], $this->path);
        if(!preg_match("#^$path$#i", trim($url, '/'), $route_params)) return false;

        array_shift($route_params);

        foreach ($route_params as $key => $param) {
            $_GET[$this->params[$key]] = $param;
        }

        $_SESSION['matches'] = $route_params;

        return true;
    }
    private function paramMatch($match): string {
        $this->params[] = $match[1];
        return isset($this->match_rules[$match[1]]) ? '(' . $this->match_rules[$match[1]] . ')' : '([^/]+)';
    }

    /** @throws Exception */
    public function call(): void {
        include_file(controller_path(str_replace('.', '/', $this->controller_path) . '_controller'));
    }
}
