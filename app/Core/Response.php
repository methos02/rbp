<?php

namespace App\Core;

class Response {
    public static function json(array $data, int $status = 200):bool {
        http_response_code($status);
        echo json_encode($data);
        return true;
    }
}
