<?php include __DIR__.'/../includes/init.php';
$meta['nom'] = "Royal Brussels Poseidon - Membre d'honneur manage";
$clubFactory = Club::factory();
$Utils = Utils::factory();
$result['message'] = '';

include ('verif/membreh_verif.php');

if($result['message'] == "") {
    $date_birth = (!empty($_POST['jour_birth']))? new DateTime($_POST['annee_birth'].'-'.$_POST['mois_birth'].'-'.$_POST['jour_birth']) : null;
    $date_death = (!empty($_POST['jour_death']))? new DateTime($_POST['annee_death'].'-'.$_POST['mois_death'].'-'.$_POST['jour_death']) : null;

    if ($date_birth != null && $date_death != null && $date_death->getTimestamp() < $date_birth->getTimestamp()){
        $result['message'] = Core_rbp::flashHTML('danger','Incohérence entre la date de naissance et de décès.');
    }
}

if ($result['message'] == "") {
    $date_birth = (is_object($date_birth))? $date_birth->format('Y-m-d') : null;
    $date_death = (is_object($date_death))? $date_death->format('Y-m-d') : null;

    $photoName = $clubFactory -> move_file('photo', Club::URL_REAL_PATH);
    $photoName = ($photoName != null)? $photoName : 'inconnu.jpg';

    $result['id_membreh'] = $clubFactory->addMembreH($_POST['nom'], $_POST['prenom'], $_POST['id_civilite'], $date_birth, $date_death, $_POST['bio'], $photoName);
    $_SESSION['flash'] = Core_rbp::flash('success',"Le membre d'honneur a bien été ajouté.");
}

echo json_encode($result);