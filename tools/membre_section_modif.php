<?php
include __DIR__.'/../includes/init.php';

$result['message'] = '';
$adherentFactory = Adherent::factory();

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier les droits d'un membre.");
}

if ($result['message'] == "" && (!isset($_POST['id_membre']) || !is_numeric($_POST['id_membre']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id du membre est invalide.");
}

if ($result['message'] == "" && (!isset($_POST['id_section']) || !is_numeric($_POST['id_section']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");
}

if ($result['message'] == "" && !isset(Section::ID_TO_NAME[$_POST['id_section']])) {
    $result['message'] = Core_rbp::flash('danger', "L'id du droit est introuvable.");
}

if($result['message'] == "" ){
    $membreSection = $adherentFactory->getMembreSection($_POST['id_membre']);

    if ($_POST['statut'] == 1 && strpos($membreSection, $_POST['id_section']) !== false) {
        $result['message'] = Core_rbp::flash('danger', "Le membre a déjà les droits pour cette section.");
    }
}

if($result['message'] == "" && isset($membreSection)) {
    if ($_POST['statut'] == 1) {
        $membreSection .= $_POST['id_section'];
    } else {
        $membreSection = str_replace($_POST['id_section'], "", $membreSection);
    }

    $adherentFactory->updateMembreSection($_POST['id_membre'], $membreSection);
    $result['message'] = ($_POST['statut'] == 1) ? Core_rbp::flash('success', "La section à bien été ajouté aux droits du membre."): Core_rbp::flash('success', "La section à bien été retirée des droits du membre.");
}

echo json_encode($result);