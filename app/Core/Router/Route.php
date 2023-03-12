<?php

namespace App\Core\Router;

use Exception;

class Route
{
    private string $path;
    private string $template_name;
    private array $params = [];

    public function __construct($path, $template_name){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->template_name = $template_name;
    }

    public function match($url): bool {
        $path = preg_replace_callback('#:(\w+)#', [$this, 'paramMatch'], $this->path);
        if(!preg_match("#^$path$#i", trim($url, '/'), $route_params)) return false;

        array_shift($route_params);
        $_SESSION['matches'] = $route_params;

        return true;
    }
    private function paramMatch($match): string {
        return isset($this->params[$match[1]]) ? '(' . $this->params[$match[1]] . ')' : '([^/]+)';
    }

    /** @throws Exception */
    public function call(): void {
        include_file(views_path($this->template_name . '.php'));
    }
}
