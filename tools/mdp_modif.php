<?php include __DIR__.'/../includes/init.php';
$factoryUser = User::factory();
$Utils = Utils::factory();
$result['message'] = "";

//Modification mot de passe
if(!isset($_POST['cle'])){
    $result['message'] = Core_rbp::flash('danger',"Clé utilisateur invalide.");
}

if($result['message'] == "" && (!isset($_POST['id_user']) || !is_numeric($_POST['id_user']))){
    $result['message'] = Core_rbp::flash('danger',"L'id utilisateur invalide.");
}

if($result['message'] == "" && (!isset($_POST['mdp_1']) || !$Utils -> checkMdp($_POST['mdp_1']))){
    $result['message'] = Core_rbp::flash('danger','Mot de passe invalide.');
}

if($result['message'] == "" && (!isset($_POST['mdp_2']) || $_POST['mdp_2'] != $_POST['mdp_1'])){
    $result['message'] = Core_rbp::flash('danger','Le deux mots de passe sont différents.');
}

if ($result['message'] == "") {
    $user = $factoryUser->verifUserBySecurity($_POST['cle'], $_POST['id_user']);

    if (empty($user)) {
        $result['message'] = Core_rbp::flash('danger', "Adresse mail introuvable.", "Veuillez contacter un responsable du club.");
    }
}

if ($result['message'] == "")  {
    //Enregistrement des infos dans la BDD
    $mdp_code = sha1('az' . htmlspecialchars($_POST['mdp_1']));
    $factoryUser->updateMdp($user['id_user'], $mdp_code);

    $_SESSION['flash'] = Core_rbp::flash('success', 'Votre mot de passe a bien été modifié');
    $result['success'] = 1;
}

echo json_encode($result);