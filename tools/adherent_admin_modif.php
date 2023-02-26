<?php include __DIR__.'/../includes/init.php';
$Utils = Utils::factory();
$adherentFactory = Adherent::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier la fiches des adhérents.");
}

if ($result['message'] == '' && (!isset($_POST['id_ads']) || !is_numeric($_POST['id_ads']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['numbRue_1']) || (!empty($_POST['numbRue_1']) && !$Utils->checkNumbAdresse($_POST['numbRue_1'])))){
    $result['message']  = Core_rbp::flash('danger', "Le numéro de l'adresse principale est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['rue_1']) || (!empty($_POST['rue_1']) && !$Utils->checkNom($_POST['rue_1'])))){
    $result['message']  = Core_rbp::flash('danger', "La rue de l'adresse principale est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['cp_1']) || (!empty($_POST['cp_1']) && !$Utils->checkCp($_POST['cp_1'])))){
    $result['message']  = Core_rbp::flash('danger', "Le code postale de l'adresse principale est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['ville_1']) || (!empty($_POST['ville_1']) && !$Utils->checkNom($_POST['ville_1'])))){
    $result['message']  = Core_rbp::flash('danger', "La ville de l'adresse principale est incorrect.");
}

if($result['message'] == '' && !$Utils->checkAdresse($_POST, '1')){
    $result['message']  = Core_rbp::flash('danger', "L'adresse principale est incomplète.");
}

if($result['message'] == '' && (!isset($_POST['numbRue_2']) || (!empty($_POST['numbRue_2']) && !$Utils->checkNumbAdresse($_POST['numbRue_2'])))){
    $result['message']  = Core_rbp::flash('danger', "Le numéro de l'adresse secondaire est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['rue_2']) || (!empty($_POST['rue_2']) && !$Utils->checkNom($_POST['rue_2'])))){
    $result['message']  = Core_rbp::flash('danger', "La rue de l'adresse secondaire est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['cp_2']) || (!empty($_POST['cp_2']) && !$Utils->checkCp($_POST['cp_2'])))){
    $result['message']  = Core_rbp::flash('danger', "Le code postale de l'adresse secondaire est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['ville_2']) || (!empty($_POST['ville_2']) && !$Utils->checkNom($_POST['ville_2'])))){
    $result['message']  = Core_rbp::flash('danger', "La ville de l'adresse secondaire est incorrect.");
}

if($result['message'] == '' && !$Utils->checkAdresse($_POST, '2')){
    $result['message']  = Core_rbp::flash('danger', "L'adresse secondaire est incomplète.");
}


if($result['message'] == '' && !empty($_POST['rue_1']) && $_POST['rue_1'] == $_POST['rue_2'] && $_POST['numbRue_1'] == $_POST['numbRue_2'] && $_POST['cp_1'] == $_POST['cp_2']){
    $result['message']  = Core_rbp::flash('danger', 'Les deux adresses introduites ne peuvent être identiques.');
}

if($result['message'] == '' && (!isset($_POST['tel']) || (!empty($_POST['tel']) && !$Utils->checkTelephone($_POST['tel'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le numéro de téléphone est incorrect");
}

if($result['message'] == '' && (!isset($_POST['gsm']) || (!empty($_POST['gsm']) && !$Utils->checkTelephone($_POST['gsm'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le numéro gsm est incorrect");
}

if($result['message'] == '' && (!isset($_POST['gsm_mere']) || (!empty($_POST['gsm_mere']) && !$Utils->checkTelephone($_POST['gsm_mere'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le numéro de gsm de la mère est incorrect");
}

if($result['message'] == '' && (!isset($_POST['gsm_pere']) || (!empty($_POST['gsm_pere']) && !$Utils->checkTelephone($_POST['gsm_pere'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le numéro de gsm du père est incorrect");
}

if($result['message'] == '' && isset($_POST['gsm'], $_POST['gsm_mere']) && !empty($_POST['gsm_mere']) && $_POST['gsm'] == $_POST['gsm_mere']){
    $result['message']  = Core_rbp::flash('danger', 'Les numéros de téléphone introduis ne peuvent être identiques.');
}

if($result['message'] == '' && isset($_POST['gsm'], $_POST['gsm_pere']) && !empty($_POST['gsm_pere']) && $_POST['gsm'] == $_POST['gsm_pere']){
    $result['message']  = Core_rbp::flash('danger', 'Les numéros de téléphone introduis ne peuvent être identiques.');
}

if($result['message'] == '' && isset($_POST['gsm_pere'], $_POST['gsm_mere']) && !empty($_POST['gsm_pere']) && $_POST['gsm_pere'] == $_POST['gsm_mere']){
    $result['message']  = Core_rbp::flash('danger', 'Les numéros de téléphone introduis ne peuvent être identiques.');
}

if($result['message'] == '' && (!isset($_POST['mail']) || (!empty($_POST['mail']) && !$Utils->checkMail($_POST['mail'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le mail est incorrect");
}

if($result['message'] == '' && (!isset($_POST['mail_mere']) || (!empty($_POST['mail_mere']) && !$Utils->checkMail($_POST['mail_mere'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le mail de la mère est incorrect");
}

if($result['message'] == '' && (!isset($_POST['mail_pere']) || (!empty($_POST['mail_pere']) && !$Utils->checkMail($_POST['mail_pere'])))) {
    $result['message']  = Core_rbp::flash('danger', "Le mail du père est incorrect");
}

if($result['message'] == '' && isset($_POST['mail'], $_POST['mail_mere']) && !empty($_POST['mail']) && $_POST['mail'] == $_POST['mail_mere']){
    $result['message']  = Core_rbp::flash('danger', 'Les adresses Emails introduis ne peuvent être identiques.');
}

if($result['message'] == '' && isset($_POST['mail_mere'], $_POST['mail_pere']) && !empty($_POST['mail_mere']) && $_POST['mail_mere'] == $_POST['mail_pere']){
    $result['message']  = Core_rbp::flash('danger', 'Les adresses Emails introduis ne peuvent être identiques.');
}

if($result['message'] == '' && isset($_POST['mail'], $_POST['mail_pere']) && !empty($_POST['mail']) && $_POST['mail'] == $_POST['mail_pere']){
    $result['message']  = Core_rbp::flash('danger', 'Les adresses Emails introduis ne peuvent être identiques.');
}

if($result['message'] == "") {
    $adherent = $adherentFactory->getAdherentSaison($_POST['id_ads']);

    if(empty($adherent)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent de correspond à l'id.");
    }
}

if($result['message'] == '' && isset($adherent)) {
    $adherentFactory->updateAdherentCoordonnee($_POST['numbRue_1'], $_POST['rue_1'], $_POST['cp_1'], $_POST['ville_1'], $_POST['numbRue_2'], $_POST['rue_2'], $_POST['cp_2'], $_POST['ville_2'], $_POST['tel'], $_POST['gsm'], $_POST['gsm_mere'], $_POST['gsm_pere'], $_POST['mail'], $_POST['mail_mere'], $_POST['mail_pere'], $adherent['id_adherent']);
    $result['message'] = Core_rbp::flash('success',"L'adhérent a été modifié.");
    $result['success'] = 1;
}

echo json_encode($result);