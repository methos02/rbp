<?php

namespace App\Core\Rules;

/** @noinspection PhpUnused */
class RequiredRule extends BaseRule {
    public function check():bool {
        return isset($_POST[$this->input_name]) && $_POST[$this->input_name] != "";
    }

    public function error():string {
        return 'Le champ "'. $this->input_name .'" est requis.';
    }
}
