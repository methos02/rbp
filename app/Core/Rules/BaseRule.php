<?php

namespace App\Core\Rules;

class BaseRule implements RuleInterface {
    public function __construct(
        readonly protected string $input_name
    ) {}

    public function check():bool { return true; }
    public function error():string { return ''; }
}
