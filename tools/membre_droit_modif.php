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

if ($result['message'] == "" && (!isset($_POST['id_droit']) || !is_numeric($_POST['id_droit']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id du droit est invalide.");
}

if ($result['message'] == "" && !isset(Droit::DROITS[$_POST['id_droit']])) {
    $result['message'] = Core_rbp::flash('danger', "L'id droit est introuvable.");
}

if ($result['message'] == "") {
    $membre = $adherentFactory->getAdherent($_POST['id_membre']);

    if(empty($membre)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun membre ne correspond à l'id renseigné.");
    }
}

if ($result['message'] == "") {
    $update = $adherentFactory->updateMembreDroit($_POST['id_membre'], $_POST['id_droit']);

    if ($_POST['id_droit'] == Droit::ADMIN || $_POST['id_droit'] == Droit::USER) {
        $adherentFactory->resetMembreSection($_POST['id_membre']);
    }

    $result['message'] = Core_rbp::flash('success', "Les droits du membres ont bien été mis à jour.");
}

echo json_encode($result);