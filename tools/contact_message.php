<?php include __DIR__ . '/../includes/init.php';
$Utils = Utils::factory();
$factoryMail = Mail::factory();
$result['message'] = "";

if(!isset($_POST['mail']) || !$Utils->checkMail($_POST['mail'])){
    $result['message'] = Core_rbp::flash('danger','Le mail est incorrect.');
}

if($result['message'] == "" && (!isset($_POST['sujet']) || !$Utils->checkTitre($_POST['sujet']))){
    $result['message'] = Core_rbp::flash('danger','Le sujet est incorrect.');
}

if($result['message'] == "" && !isset($_POST['message'])){
    $result['message'] = Core_rbp::flash('danger','Texte incorrect.');
}

if($result['message'] == "" && (!isset($_POST['id_destinataire']) || !isset(Mail::ARR_CONTACT_ID_TO_MAIL[$_POST['id_destinataire']]))){
    $result['message'] = Core_rbp::flash('danger','Le destinataire est incorrect.');
}

if($result['message'] == ""){
    $factoryMail->mailContact(Mail::ARR_CONTACT_ID_TO_MAIL[$_POST['id_destinataire']], $_POST['mail'], $_POST['message'], $_POST['sujet']);
    $result['message'] = Core_rbp::flash('success','Le mail a bien été envoyé');
}

echo json_encode($result);