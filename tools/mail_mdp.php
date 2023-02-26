<?php include __DIR__.'/../includes/init.php';
$factoryUser = User::factory();
$factoryMail = Mail::factory();
$Utils = Utils::factory();
$result['message'] = "";

if(!isset($_POST['mail']) || !$Utils->checkMail($_POST['mail'])){
    $result['message'] = Core_rbp::flash('danger','Mail invalide.');
}

if ($result['message'] == "") {
    $user = $factoryUser->getUserByMail($_POST['mail']);

    if (empty($user)) {
        $result['message'] = Core_rbp::flash('danger', "Adresse mail introuvable.", "Veuillez contacter un responsable du club.");
    }

    if ($result['message'] == "" && $user['adh_cle'] == null) {
        $result['message'] = Core_rbp::flash('danger', "Le compte n'a pas encore été validé.");
    }
}

if ($result['message'] == "") {
    $factoryMail->mailNewMdp($_POST['mail'], $user['adh_id'], $user['adh_cle']);
    $result['message'] = Core_rbp::flash('success', 'Mail de réinitialisation de mot de passe envoyé.', 'Si vous ne l\'avez toujours pas reçu, vérifiez vos courriers indésirables.');
}

echo json_encode($result);