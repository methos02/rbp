<?php
include __DIR__ . '/../includes/init.php';
$mailFactory = Mail::factory();
$result['message'] = "";

if(!isset($_GET['cle'])) {
    $_SESSION['flash'] = Core_rbp::flash('danger', "Les données fournies sont incomplètes.");
}

if($_SESSION['flash'] == "") {
    $supp = $mailFactory->suppMailNews($_GET['cle']);

    if($supp == 1){
        $_SESSION['flash'] = Core_rbp::flash('success', "Votre adresse a bien été retirée de la mailling-list.");
    } else {
        $_SESSION['flash'] = Core_rbp::flash('danger', "Un problème est survenu, l'adresse n'existe pas ou à déjà été supprimée.");
    }
}

header('location:'.URL_SITE.'accueil');
exit();