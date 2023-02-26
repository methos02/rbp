<?php
if($log['droit'] <= Droit::REDAC ){
    $result['message'] = Core_rbp::flash('danger',"L'ID du membre est invalide.");
}

if($result['message'] == '' && !isset($_POST['nom']) || !$Utils->checkNom($_POST['nom'])){
    $result['message'] = Core_rbp::flash('danger',"Nom incorrect");
}

if($result['message'] == '' && (!isset($_POST['prenom']) || !$Utils->checkNom($_POST['prenom']))){
    $result['message'] = Core_rbp::flash('danger',"Prénom incorrect");
}

if($result['message'] == "" && !isset($_POST['jour_birth'],$_POST['mois_birth'], $_POST['annee_birth'])){
    $result['message'] = Core_rbp::flash('danger', "Il manque un paramètre de la date de naissance.");
}

if ($result['message'] == "" && (!empty($_POST['jour_birth']) || !empty($_POST['mois_birth']) || !empty($_POST['annee_birth'])) && !$Utils->checkDate($_POST['jour_birth'],$_POST['mois_birth'], $_POST['annee_birth'], 'passe')){
    $result['message'] = Core_rbp::flash('danger', "Date de naissance incorrecte.");
}

if($result['message'] == "" && !isset($_POST['jour_death'],$_POST['mois_death'], $_POST['annee_death'])){
    $result['message'] = Core_rbp::flash('danger', "Il manque un paramètre de la date de décès.");
}

if ($result['message'] == "" && (!empty($_POST['jour_death']) || !empty($_POST['mois_death']) || !empty($_POST['annee_death'])) && !$Utils->checkDate($_POST['jour_death'],$_POST['mois_death'], $_POST['annee_death'], 'passe')){
    $result['message'] = Core_rbp::flash('danger', "Date de décès incorrecte.");
}

if($result['message'] == '' && (!isset($_POST['bio']) || empty($_POST['bio']))){
    $result['message'] = Core_rbp::flash('danger',"Biographie incorrect");
}

if($result['message'] == '' && (!isset($_POST['id_civilite']) || !is_numeric($_POST['id_civilite']))){
    $result['message'] = Core_rbp::flash('danger',"L'id civilité incorrecte.");
}

if($result['message'] == '' && !isset(Database::CIV_ID_TO_NAME[$_POST['id_civilite']])){
    $result['message'] = Core_rbp::flash('danger',"Civilité introuvable.");
}

if($result['message']=='' && (!isset($_FILES['photo']) || !$Utils->checkFichier('photo', Club::EXT_PHOTO, Club::SIZE_PHOTO, Club::DIM_PHOTO))){
    $result['message'] = Core_rbp::flash('danger',"La photo est incorrect", $Utils -> getErreur());
}
