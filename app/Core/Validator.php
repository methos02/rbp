<?php

namespace App\Core;

use App\Core\Rules\RuleInterface;

class Validator {
    private array $rules_fields;
    private array $errors = [];
    private array $valides_fields = [];
    public function __construct(
        readonly private string $file_rules
    ){
        $this->rules_fields = include request_path($this->file_rules . '.php');
    }

    public function validate():array {
        foreach ($this->rules_fields as $input_name => $rules_field) {
            $rules = explode('|', $rules_field);

            foreach ($rules as $rule) {
                $class_name = 'App\Core\Rules\\' . ucfirst($rule) . 'Rule';
                /** @var RuleInterface $rule_class */
                $rule_class = new $class_name($input_name);

                if(!$rule_class->check()) {
                    $this->errors[$input_name] = $rule_class->error();
                    break;
                }
            }

            if(!isset($this->errors[$input_name])) $this->valides_fields[$input_name] = $_POST[$input_name];
        }

        return $this->valides_fields;
    }

    public function errors(): array { return $this->errors; }
    public function hasErrors(): bool { return !empty($this->errors);}
    public function validated(): array { return $this->valides_fields; }
}
