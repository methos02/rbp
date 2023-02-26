<?php
include __DIR__ . '/../includes/init.php';
$sponsorFactory = Sponsor::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour supprimer un sponsor.");
}

if ( $result['message'] == "" && (!isset($_POST['id_sponsor']) || !is_numeric($_POST['id_sponsor']))) {
    $result['message'] = Core_rbp::flash('danger', 'ID du sponsor est invalide.');
}

if ($result['message'] == "") {
    $supp = $sponsorFactory -> suppSponsor($_POST['id_sponsor']);

    if($supp == 0) {
        $result['message'] = Core_rbp::flash('danger', 'Sponsor introuvable.');
    } else {
        $result['message'] = Core_rbp::flash('success', 'Le sponsor a bien été supprimé.');
        $result['success'] = 1;
    }
}

echo json_encode($result);