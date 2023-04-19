<?php

namespace App\Core;

use App\Models\User;

class Auth {
    private static ?User $user = null;

    public static function log_user():void {
        if(defined('script_name')) return;
        if(!isset($_SESSION['auth']['email'], $_SESSION['auth']['token'])) return;

        self::$user = User::where(['email' => $_SESSION['auth']['email'], 'token' => $_SESSION['auth']['token']])->first();

        if(empty(self::$user)) {
            unset($_SESSION['auth']['key'], $_SESSION['auth']['email']);
            Response::redirectWithFlash('/', ['danger', 'Paramètres de connexion invalide']);
        }
    }
    public static function can(int $permission):bool {
        return isset($_SESSION['auth']['droit']) && $_SESSION['auth']['droit'] >=  $permission;
    }
    public static function is_log():bool {
        return !is_null(self::$user);
    }
    public static function is_admin():bool {
        return self::$user->get('roles') == 'admin';
    }

}
