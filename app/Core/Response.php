<?php

namespace App\Core;

class Response {
    public static function json(array $data):bool {
        echo json_encode($data);
        return true;
    }
}
