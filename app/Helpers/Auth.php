<?php

namespace App\Helpers;

use Droit;

class Auth {
    public static function can(int $permission):bool {
        return isset($_SESSION['auth']['droit']) && $_SESSION['auth']['droit'] >=  $permission;
    }
    public static function is_log():bool {
        return isset($_SESSION['auth']['droit']) && $_SESSION['auth']['droit'] > Droit::USER;
    }
}
