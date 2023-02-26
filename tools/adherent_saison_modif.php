<?php include __DIR__ . '/../includes/init.php';
$Utils = Utils::factory();
$adherentFactory = Adherent::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier la fiches des adhérents.");
}

if ($result['message'] == "" && (!isset($_POST['id_ads']) || !is_numeric($_POST['id_ads']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['id_licence']) || !$Utils->checkSelect($_POST['id_licence']))){
    $result['message']  = Core_rbp::flash('danger','Le type de licence est incorrect.');
}

if($result['message'] == '' && (!isset($_POST['numb_licence']) || ($_POST['numb_licence'] != 'vide' && !$Utils->checkNumbLicence($_POST['numb_licence'])))){
    $result['message']  = Core_rbp::flash('danger','Le numéro de licence est incorrect.');
}

if($result['message'] == "" && !isset($_POST['jour_licence'], $_POST['mois_licence'], $_POST['annee_licence'])){
    $result['message']  = Core_rbp::flash('danger','Il manque un paramètre de la date de licence.');
}

if($result['message']  == "" && (!empty($_POST['jour_licence']) || !empty($_POST['mois_licence']) || !empty($_POST['annee_licence'])) && !$Utils->checkDate($_POST['jour_licence'], $_POST['mois_licence'], $_POST['annee_licence'], 'scolaire')){
    $result['message']  = Core_rbp::flash('danger','Date de licence incorrecte');
}

if ($result['message'] == "" && !isset($_POST['jour_licence'], $_POST['mois_licence'], $_POST['annee_licence'])){
    $result['message']  = Core_rbp::flash('danger','Il manque un paramètre de la date de certificat médicale.');
}

if($result['message'] == "" && (!empty($_POST['jour_certif']) || !empty($_POST['mois_certif']) || !empty($_POST['annee_certif'])) && !$Utils->checkDate($_POST['jour_certif'], $_POST['mois_certif'], $_POST['annee_certif'], 'scolaire')){
    $result['message'] = Core_rbp::flash('danger','Date du certificat médicale incorrecte');
}

if($result['message'] == '' && (!isset($_POST['id_cotisation']) || !$Utils->checkSelect($_POST['id_cotisation']))){
    $result['message'] = Core_rbp::flash('danger','La cotisation a payer est incorrect.');
}

if($result['message'] == "" && !isset($_POST['jour_cotisation'],$_POST['mois_cotisation'], $_POST['annee_cotisation'])){
    $result['message']  = Core_rbp::flash('danger','Il manque un paramètre de la date de certificat médicale.');
}

if($result['message'] == "" && (!empty($_POST['jour_cotisation']) || !empty($_POST['mois_cotisation']) || !empty($_POST['annee_cotisation'])) && !$Utils->checkDate($_POST['jour_cotisation'], $_POST['mois_cotisation'], $_POST['annee_cotisation'], 'scolaire')){
    $result['message'] = Core_rbp::flash('danger','Date de cotisation incorrecte', $Utils->getErreur());
}

if($result['message'] == '' && (!isset($_POST['montant']) || (!empty($_POST['montant']) && !$Utils->checkNumb($_POST['montant'])))){
    $result['message'] = Core_rbp::flash('danger','Le montant de la cotisation est incorrect.');
}

if($result['message'] == '' && !empty($_POST['montant']) && !in_array($_POST['id_cotisation'], [5,6]) && $_POST['montant'] > Database::COT_ID_TO_NUMB[$_POST['id_cotisation']]){
    $result['message'] = Core_rbp::flash('danger','Le montant de la cotisation perçu et plus élevé que celui réclamé.');
}

if($result['message'] == "") {
    $id_adherent = $adherentFactory->getAdherentSaison($_POST['id_ads']);

    if(empty($id_adherent)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent de correspond à l'id.");
    }
}

if($result['message'] == "") {
    $montant = is_numeric($_POST['montant'])? $_POST['montant'] : null;

    $date_licence = (!empty($_POST['jour_licence']))? $_POST['annee_licence'].'-'.$_POST['mois_licence'].'-'.$_POST['jour_licence']: null;
    $date_certif = (!empty($_POST['jour_certif']))? $_POST['annee_certif'].'-'.$_POST['mois_certif'].'-'.$_POST['jour_certif']: null;
    $date_cotisation = (!empty($_POST['jour_cotisation']))? $_POST['annee_cotisation'].'-'.$_POST['mois_cotisation'].'-'.$_POST['jour_cotisation']: null;

    $licence = (!empty($_POST['jour_licence']) && $_POST['id_licence'] != Database::L_NON_INFO && !empty($_POST['numb_licence']))? 1 : 0;
    $certif = (!empty($_POST['jour_certif']) || $_POST['id_licence'] == Database::L_NON_LICENCIER)? 1 : 0;
    $cotisation = $adherentFactory->verifCotisation($_POST['id_cotisation'], $montant, $_POST['jour_cotisation']);

    $adherentFactory->updateAdherentSaison($_POST['id_ads'], $licence, $_POST['id_licence'], $_POST['numb_licence'], $date_licence, $certif, $date_certif, $cotisation, $_POST['id_cotisation'], $date_cotisation, $montant);

    $result['message'] = Core_rbp::flash('success',"L'adhérent a été modifié.");
    $result['success'] = 1;
}

echo json_encode($result);