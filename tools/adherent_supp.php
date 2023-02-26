<?php
include __DIR__.'/../includes/init.php';

$result['message'] = '';
$adherentFactory = Adherent::factory();

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour supprimer un adhérent.");
}

if ($result['message'] == "" && (!isset($_POST['id_adherent']) || !is_numeric($_POST['id_adherent']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est invalide.");
}

if ($result['message'] == "") {
    $supp = $adherentFactory->suppAdherent($_POST['id_adherent']);

    if ($supp == 1) {
        $result['message'] = Core_rbp::flash('success', "L'adhérent a été supprimé.");
        $result['success'] = 1;
    } else {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent ne correspond à l'id.");
    }
}

echo json_encode($result);