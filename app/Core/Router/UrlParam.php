<?php

namespace App\Core\Router;

class UrlParam {
    public static function get($name):?string {
        return $_SESSION['matches'][$name] ?? null;
    }
}
