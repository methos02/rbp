<?php include __DIR__.'/../includes/init.php';
$factoryUser = User::factory();
$factoryMail = Mail::factory();
$Utils = Utils::factory();
$result['message'] = "";

if(!isset($_POST['mail']) || !$Utils -> checkMail($_POST['mail'])){
    $result['message'] = Core_rbp::flash('danger','Mail invalide.');
}

if ($result['message'] == "") {
    $user = $factoryUser->verifUser($_POST['mail']);

    if(empty($user)){
        $result['message'] = Core_rbp::flash('danger',"Adresse mail introuvable.", "Veuillez contacter un responsable du club.");
    }

    if($result['message'] == "" && $user['cle'] != null){
        $result['message'] = Core_rbp::flash('danger','Compte est déjà actif.');
    }

    if($result['message'] == "" && $user['adh_droit'] == Droit::USER){
        $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas le droit de vous inscrire.", "Contactez un administrateur pour qu'il vous pré-inscrive.");
    }
}

if ($result['message'] == "") {
    $factoryMail->mailValidation(rtrim($_POST['mail']));
    $result['message'] = Core_rbp::flash('success','Mail de validation d\'inscription vous a été réenvoyé.','Si vous ne l\'avez toujours pas reçu, vérifiez vos courriers indésirables.');
}

echo json_encode($result);