<?php

namespace App\Core;

use JetBrains\PhpStorm\NoReturn;

class Response {
    public static function json(array $data, int $status = 200):bool {
        http_response_code($status);
        echo json_encode($data);
        return true;
    }

    #[NoReturn] public static function redirect($url):void {
        http_response_code(302);
        header('Location: '. $url );
        die();
    }
    #[NoReturn] public static function redirectWithError(string $url, array $error):void {
        $_SESSION['errors'] = $error;
        self::redirect($url);
    }
    #[NoReturn] public static function redirectWithFlash(string $url, array $flash):void {
        $_SESSION['flash'] = $flash;
        self::redirect($url);
    }
}
