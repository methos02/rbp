<?php
if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
}

if ($result['message'] == ''  && (!isset($_POST['id_section']) || !in_array($_POST['id_section'], [Section::NATATION['id'], Section::PLONGEON['id']]))){
    $result['message'] = Core_rbp::flash('danger', "L'id section est invalide");
}

if ($result['message'] == "" && (!isset($_POST['nom_competition']) || !$Utils->checkNomEvent($_POST['nom_competition']))){
    $result['message'] = Core_rbp::flash('danger', 'Nom de la compétition incorrect.');
}

if ($result['message'] == "" && (!isset($_POST['jour_in'], $_POST['mois_in'], $_POST['annee_in']) || !$Utils->checkDate($_POST['jour_in'],$_POST['mois_in'], $_POST['annee_in'], 'scolaire'))){
    $result['message'] = Core_rbp::flash('danger', 'Date du début de la compétition incorrecte.');
}

if($result['message'] == "" && !isset($_POST['jour_out'], $_POST['mois_out'], $_POST['annee_out'])){
    $result['message'] = Core_rbp::flash('danger', "Il manque un paramètre de la date de fin.");
}

if ($result['message'] == "" && (!empty($_POST['jour_out']) || !empty($_POST['mois_out']) || !empty($_POST['annee_out'])) && !$Utils->checkDate($_POST['jour_out'],$_POST['mois_out'], $_POST['annee_out'], 'scolaire')){
    $result['message'] = Core_rbp::flash('danger', "Date de fin incorrecte.", $Utils->getErreur());
}

if ($result['message'] == "" && (!isset($_POST['statut']) || !in_array($_POST['statut'], [Competition::S_ANNULE, Competition::S_PRESENT, Competition::S_PAS_PRESENT]))){
    $result['message'] = Core_rbp::flash('danger','Statut incorrect.');
}

if ($result['message'] == "" && (!isset($_POST['heure_rdv']) || !isset($_POST['minute_rdv']) || !$Utils->checkHeure($_POST['heure_rdv'], $_POST['minute_rdv']))){
    $result['message'] = Core_rbp::flash('danger','Heure incorrecte.');
}

if ($result['message'] == "") {
    $date_in = new DateTime($_POST['annee_in'].'-'.$_POST['mois_in'].'-'.$_POST['jour_in']);
    $date_out = (!empty($_POST['annee_out']))? new DateTime($_POST['annee_out'].'-'.$_POST['mois_out'].'-'.$_POST['jour_out']): '';

    if (is_object($date_out) && $date_out->getTimestamp() < $date_in->getTimestamp()){
        $result['message'] = Core_rbp::flash('danger','Incohérence entre la date de début et de fin.');
    }
}

if($result['message'] == "" && !empty($_POST['id_piscine']) && !is_numeric($_POST['id_piscine'])){
    $result['message'] = Core_rbp::flash('danger', "L'id piscine est invalide.");
}

if($result['message'] == "" && !isset($_POST['add_piscine']) && empty($_POST['id_piscine'])) {
    $_POST['id_piscine'] = null;
}

if ($result['message'] == "" && (!isset($_FILES['resultat']) || !$Utils->checkFichier('resultat', Competition::FICHIER_EXT, Competition::FICHIER_SIZE))){
    $result['message'] = Core_rbp::flash('danger','Fichier "résultat" incorrect.', $Utils -> getErreur());
}

if ($_POST['id_section'] == Section::NATATION['id']){
    if ($result['message'] == "" && (!isset($_FILES['programme']) && !$Utils->checkFichier('programme', Competition::FICHIER_EXT, Competition::FICHIER_SIZE))){
        $result['message'] = Core_rbp::flash('danger','Fichier "programme" incorrect.', $Utils -> getErreur());
    }

    if ($result['message'] == "" && (!isset($_FILES['liste']) && !$Utils->checkFichier('liste', Competition::FICHIER_EXT, Competition::FICHIER_SIZE))){
        $result['message'] = Core_rbp::flash('danger','Fichier "liste" incorrect.', $Utils -> getErreur());
    }
}

if ($result['message'] == "" && !is_dir(__DIR__.'/../..'.Competition::FICHIER_REAL_PATH)) {
    $result['message'] = Core_rbp::flash('danger', "Le chemin pour enregistré les photos est invalide.");
}