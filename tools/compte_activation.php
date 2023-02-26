<?php include __DIR__ . '/../includes/init.php';
$factoryUser = User::factory();
$Utils = Utils::factory();
$result['message'] = "";

if(!isset($_GET['mail']) || !$Utils -> checkMail($_GET['mail'])){
    $_SESSION['flash'] = Core_rbp::flash('danger','Mail invalide');
}

if(!isset($_SESSION['flash'])) {
    $user = $factoryUser->verifUser($_GET['mail']);

    if(empty($user)){
        $_SESSION['flash'] = Core_rbp::flash('danger',"Adresse mail introuvable.", "Veuillez contacter un responsable du club.");
    }

    if(!isset($_SESSION['flash']) && $user['cle'] != null){
        $_SESSION['flash'] = Core_rbp::flash('danger','Compte est déjà actif.');
    }
}

if(!isset($_SESSION['flash'])) {
    $cle = md5(microtime(TRUE)*100000);
    $factoryUser->confirmeUser($_GET['mail'], $cle);
    $_SESSION['flash'] = Core_rbp::flash('success','Votre compte a été activé.');
}

header('location:'.URL_SITE.'accueil.html');