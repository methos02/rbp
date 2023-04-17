<?php

namespace App\Core\Rules;

class EmailRule extends BaseRule {
    public function check():bool {
        return preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$_POST[$this->input_name]);
    }

    public function error():string {
        return "L'email semble invalide.";
    }
}
