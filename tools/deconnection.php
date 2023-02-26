<?php include __DIR__.'/../includes/init.php';

unset($_SESSION['auth']);
$_SESSION['flash'] = Core_rbp::flash('success','Vous avez été déconnecté.');

header("location:" . URL_SITE . "accueil");