<?php

namespace App\Helpers;

class Html {
    public static function disabled(bool $condition) {
        return $condition ? ' disabled="disabled"' : '';
    }
    public static function add_if($class, $condition):string {
        return $condition ? ' ' . $class : '';
    }
    public static function error($input_name = ""):string {
        if(!isset($_SESSION['errors'][$input_name])) return '';
        $message_error = $_SESSION['errors'][$input_name];
        if($input_name != "") unset($_SESSION['errors'][$input_name]);
        return '<p class="message-error">' . $message_error . '</p>';
    }
}
