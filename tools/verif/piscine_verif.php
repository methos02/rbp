<?php
if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
}

if ($result['message'] == "" && (!isset($_POST['nom_piscine']) || !$Utils->checkNomEvent($_POST['nom_piscine']))){
    $result['message'] = Core_rbp::flash('danger', 'Nom de la piscine incorrect.');
}

if ($result['message'] == "" && (!isset($_POST['rue_piscine']) || !$Utils->checkNom($_POST['rue_piscine']))){
    $result['message'] = Core_rbp::flash('danger','Rue incorrecte.');
}

if ($result['message'] == "" && (!isset($_POST['numbRue_piscine']) || (!empty($_POST['numbRue_piscine']) && !$Utils->checkNumbAdresse($_POST['numbRue_piscine'])))){
    $result['message'] = Core_rbp::flash('danger','Numéro de rue incorrect.');
}

if ($result['message'] == "" && (!isset($_POST['cp_piscine']) || !$Utils->checkCp($_POST['cp_piscine']))){
    $result['message'] = Core_rbp::flash('danger','Code postale incorrect.');
}

if ($result['message'] == "" && (!isset($_POST['ville_piscine']) || !$Utils->checkNom($_POST['ville_piscine']))){
    $result['message'] = Core_rbp::flash('danger','Ville incorrecte.');
}