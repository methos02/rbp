<?php

namespace App\Core;

use Section;

class Request {
    public static function get($key):?string {
        $check_method = 'get_' . $key;
        if(method_exists(self::class, $check_method)) return self::$check_method();
        return $_GET[$key] ?? null;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_section_id():?string {
        return isset($_GET['section_id']) && in_array($_GET['section_id'], Section::SECTIONS_ID) ? $_GET['section_id'] : null;
    }
    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_page():?string {
        return isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0 ? $_GET['section_id'] : null;
    }
}
