<?php

namespace App\Core;

use Section;

class Request {
    public static function get($key):?string {
        $check_method = 'get_' . $key;
        if(method_exists(self::class, $check_method)) return self::$check_method();
        return $_GET[$key] ?? null;
    }

    public static function contains(string $string):bool {
        return str_contains($_SERVER['REQUEST_URI'], $string);
    }

    public static function validate(string $request_path, string $redirect = null):array {
        ($validator = new Validator($request_path))->validate();

        if($validator->hasErrors() && self::isAjax()) { Response::json($validator->errors(), 422); die(); }

        if($validator->hasErrors()) {
            $_SESSION['errors'] = $validator->errors();
            header('Location: '. (!is_null($redirect) ? $redirect : $_SERVER["HTTP_REFERER"] ));
            die();
        }

        return $validator->validated();
    }

    public static function isAjax():bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_section():?string {
        if(isset($_GET['section']) && (!in_array($_GET['section'], array_keys(Section::GET_SECTIONS)))) Utils::flash('danger', "La section est invalide.");
        return isset($_GET['section']) && in_array($_GET['section'], array_keys(Section::GET_SECTIONS)) ? $_GET['section'] : null;
    }
    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function get_page():int {
        if(isset($_GET['page']) && (!is_numeric($_GET['page']) || $_GET['page'] < 0)) Utils::flash('danger', "La page est invalide.");
        return isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0 ? $_GET['page'] : 0;
    }
}
