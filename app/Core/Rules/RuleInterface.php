<?php

namespace App\Core\Rules;

interface RuleInterface {
    public function check():bool;
    public function error():string;
}
