<?php
const script_name = __FILE__;

include __DIR__ . '/includes/init.php';

$scripts = ['migrate:fresh' => '/command'];

list($script, $action) = explode(':', $argv[1]);

include_once "commands/$script/{$script}_$action.php" ;
