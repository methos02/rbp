<?php
//Include config file
include __DIR__.'/conf.php';

//Secure PHP Settings
ini_set("magic_quotes_gpc", "off");
ini_set('date.timezone', 'Europe/Paris');
date_default_timezone_set("Europe/Paris"); //set for the timezone
ini_set('default_charset', 'utf-8');
mb_internal_encoding('UTF-8');

//Start the session
@session_start();
include __DIR__.'/../class/Core_rbp.php';
include __DIR__.'/../class/Table.php';

include __DIR__.'/../class/Adherent.php';
include __DIR__.'/../class/Article.php';
include __DIR__.'/../class/Calendrier.php';
include __DIR__.'/../class/Club.php';
include __DIR__.'/../class/Connection.php';
include __DIR__.'/../class/Competition.php';
include __DIR__.'/../class/Database.php';
include __DIR__.'/../class/Droit.php';
include __DIR__.'/../class/Form.php';
include __DIR__.'/../class/Mail.php';
include __DIR__.'/../class/Match.php';
include __DIR__.'/../class/News.php';
include __DIR__.'/../class/Piscine.php';
include __DIR__.'/../class/Photo.php';
include __DIR__.'/../class/Saison.php';
include __DIR__.'/../class/Section.php';
include __DIR__.'/../class/Sponsor.php';
include __DIR__.'/../class/User.php';
include __DIR__.'/../class/Utils.php';

include __DIR__.'/../vendor/autoload.php';

if(!isset($_SESSION['already_visited']) && !in_array($_SERVER['REMOTE_ADDR'], array('81.240.125.88'))){
    $_SESSION['already_visited'] = true;
    Core_rbp::visiteur();
}

$log = Droit::factory()->getLog();
$meta = [];