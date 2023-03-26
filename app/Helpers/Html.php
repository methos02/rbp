<?php

namespace App\Helpers;

class Html {
    public static function disabled(bool $condition) {
        return $condition ? ' disabled="disabled"' : '';
    }
}
