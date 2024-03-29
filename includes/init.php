<?php
//Include config file
use App\Core\Auth;
use App\Core\Core_rbp;

include __DIR__.'/conf.php';

//Secure PHP Settings
ini_set("magic_quotes_gpc", "off");
ini_set('date.timezone', 'Europe/Paris');
date_default_timezone_set("Europe/Paris"); //set for the timezone
ini_set('default_charset', 'utf-8');
mb_internal_encoding('UTF-8');

//Start the session
@session_start();

include dirname(__DIR__ ).'/app/helpers/path_helpers.php';
include dirname(__DIR__ ).'/app/helpers/files_helpers.php';
include dirname(__DIR__ ).'/app/helpers/url_helpers.php';
include dirname(__DIR__ ).'/app/helpers/debug_helpers.php';
include dirname(__DIR__ ).'/app/helpers/vite_helpers.php';

include dirname(__DIR__ ).'/vendor/autoload.php';

spl_autoload_register(function($class) {
    $file = dirname(__DIR__) . join(DIRECTORY_SEPARATOR, ['\class', $class.'.php']) ;
    return file_exists($file) ? require_once $file : false;
});

if((!defined('script_name') ||  !str_contains(script_name, 'command'))  && !isset($_SESSION['already_visited']) && !in_array($_SERVER['REMOTE_ADDR'], array('81.240.125.88'))){
    $_SESSION['already_visited'] = true;
    Core_rbp::visiteur();
}

$params = [];

Auth::log_user();

$params['meta'] = [];
return $params;
