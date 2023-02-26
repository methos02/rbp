<?php include __DIR__ . '/../includes/init.php';
$factoryUser = User::factory();
$Utils = Utils::factory();

if(!isset($_POST['mail']) || !$Utils -> checkMail($_POST['mail'])){
    $_SESSION['flash'] = Core_rbp::flash('danger','Adresse mail invalide.');
}

if(!isset($_SESSION['flash']) && (!isset($_POST['mdp']) || !$Utils -> checkMdp($_POST['mdp']))){
    $_SESSION['flash'] = Core_rbp::flash('danger','Mot de passe invalide.');
}

/*Récupération de du compte */
if(!isset($_SESSION['flash'])){
    $user = $factoryUser -> connectUser($_POST['mail'], sha1 ( 'az' .$_POST['mdp']));

    if(empty($user)){
        $_SESSION['flash'] = Core_rbp::flash('danger','Aucun compte trouvé.','Adresse mail ou mot de passe invalide.');
    }

    if(!isset($_SESSION['flash']) && $user['adh_droit'] == 0) {
        $_SESSION['flash'] = Core_rbp::flash('danger',"Connexion refusée.", "Vous n'avez pas les droits pour vous connecter.");
    }
}

if(!isset($_SESSION['flash'])){
    $_SESSION['auth']['cle'] = $user['adh_cle'];
    $_SESSION['auth']['mail'] = $user['adh_mail'];

    unset($_SESSION['connect']);
    $_SESSION['flash'] = Core_rbp::flash('success','Vous êtes bien connecté.');
}

header('Location: '.$_SERVER["HTTP_REFERER"] );