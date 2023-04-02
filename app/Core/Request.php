<?php

namespace App\Core;

use Section;

class Request {
    public static function get($key):?string {
        $check_method = 'get_' . $key;
        if(method_exists(self::class, $check_method)) return self::$check_method();
        return $_GET[$key] ?? null;
    }

    public static function isAjax():bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_section():?string {
        return isset($_GET['section']) && in_array($_GET['section'], array_keys(Section::GET_SECTIONS)) ? $_GET['section'] : null;
    }
    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_page():?string {
        return isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0 ? $_GET['section_id'] : null;
    }
}
