<?php

namespace App\Core;

class Utils {
    public static function flash($type, $title, $message = '' ):void {
        $_SESSION['flash'] = compact('type', 'title', 'message');
    }
}
