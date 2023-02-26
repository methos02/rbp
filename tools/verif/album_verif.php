<?php
if($log['droit'] == Droit::USER ){
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits.");
}

if($result['message'] == "" && (!isset($_POST['nom']) || !$Utils -> checkNomEvent($_POST['nom']))) {
    $result['message'] = Core_rbp::flash('danger', "Le nom de l'album est invalide.");
}

if($result['message'] == "" && (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison']))){
    $result['message'] = Core_rbp::flash('danger', "L'id de la saison est invalide.");
}

if($result['message'] == "" && (!isset($_POST['id_section']) || !is_numeric($_POST['id_section']))){
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");
}

if($result['message'] == "" && !isset(Section::ID_TO_NAME[$_POST['id_section']])) {
    $result['message'] = Core_rbp::flash('danger', "Aucune section ne correspond à l'id fournie.");
}

if($result['message'] == "") {
    $saison = Saison::factory()->getSaison($_POST['id_saison']);

    if(empty($saison)) {
        $result['message'] = Core_rbp::flash('danger', "Aucune saison ne correspond à l'id fournie.");
    }
}