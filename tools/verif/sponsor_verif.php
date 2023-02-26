<?php
if (!isset($_POST['nom']) || !$Utils->checkNom($_POST['nom'])) {
    $result['message'] = Core_rbp::flash("danger", "Le nom est incorrect");
}

if ($result['message'] == '' && (!isset($_FILES['logo']) || !$Utils->checkFichier('logo', Sponsor::EXT_LOGO, Sponsor::SIZE_LOGO, Sponsor::DIM_LOGO))) {
    $result['message'] = Core_rbp::flash("danger","Le logo est incorrect", $Utils -> getErreur());
}

if ($result['message']=='' && (!isset($_POST['numbRue_sponsor']) || (!empty($_POST['numbRue_sponsor']) && !$Utils->checkNumbAdresse($_POST['numbRue_sponsor'])))) {
    $result['message'] = Core_rbp::flash("danger","Le numéro de rue est incorrect");
}

if ($result['message']=='' && (!isset($_POST['rue_sponsor']) || (!empty($_POST['rue_sponsor']) && !$Utils->checkNom($_POST['rue_sponsor'])))) {
    $result['message'] = Core_rbp::flash("danger","La rue est incorrect");
}

if ($result['message']=='' && (!isset($_POST['cp_sponsor']) || (!empty($_POST['cp_sponsor']) && !$Utils->checkCp($_POST['cp_sponsor'])))) {
    $result['message'] = Core_rbp::flash("danger","Le code postale est incorrect");
}

if ($result['message']=='' && (!isset($_POST['ville_sponsor']) || (!empty($_POST['ville_sponsor']) && !$Utils->checkNom($_POST['ville_sponsor'])))) {
    $result['message'] = Core_rbp::flash("danger","La ville est incorrect");
}

if ($result['message']=='' && (!isset($_POST['tel']) || (!empty($_POST['tel']) && !$Utils->checkTelephone($_POST['tel'])))) {
    $result['message'] = Core_rbp::flash("danger","Le numéro de téléphone est incorrect");
}

if ($result['message']=='' && (!isset($_POST['mail']) || (!empty($_POST['mail']) && !$Utils->checkMail($_POST['mail'])))) {
    $result['message'] = Core_rbp::flash("danger","Le mail est incorrect");
}

if ($result['message']=='' && (!isset($_POST['site']) || (!empty($_POST['site']) && !$Utils->checkSite($_POST['site'])))) {
    $result['message'] = Core_rbp::flash("danger","L'adresse du site web est incorrect");
}

if ($result['message'] == '' && (!isset($_POST['description']) || empty($_POST['description']))) {
    $result['message'] = Core_rbp::flash("danger","Description incorrect");
}

if ($result['message'] == '' && (!isset($_POST['id_section']) || !$Utils->checkSelect($_POST['id_section']))) {
    $result['message'] = Core_rbp::flash("danger","La section est incorrect");
}

if ($result['message'] == '' && (!isset($_POST['id_domaine']) || !$Utils->checkSelect($_POST['id_domaine']))) {
    $result['message'] = Core_rbp::flash("danger","Le domaine est incorrect");
}

if ($result['message'] == "" && !is_dir(__DIR__.'/../..' . Sponsor::URL_REAL_PATH)) {
    $result['message'] = Core_rbp::flash('danger', "Le chemin pour enregistré les photos est invalide.");
}