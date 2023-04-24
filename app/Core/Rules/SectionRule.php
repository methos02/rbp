<?php

namespace App\Core\Rules;

use Section;

/** @noinspection PhpUnused */
class SectionRule extends BaseRule {
    public function check():bool {
        return isset(Section::SECTIONS[$_POST[$this->input_name]]);
    }

    public function error():string {
        return 'La section est invalide.';
    }
}
