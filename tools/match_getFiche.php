<?php

use App\Core\Core_rbp;

include __DIR__ . '/../includes/init.php';
$matchFactory = MatchM::factory();
$piscineFactory = Piscine::factory();

if (!isset($_POST['id_match']) || !is_numeric($_POST['id_match'])) {
    $resultat['message'] = ['danger',"L'id match invalide."];
}

if (!isset($resultat['message'])) {
    $match = $matchFactory->getMatch($_POST['id_match']);

    if ( empty($match)) {
        $resultat['message'] = ['danger',"Aucun match ne correspond à l'id envoyée."];
    }
}

if(!isset($resultat['message']) && $match['id_piscine'] != null){
    $piscine = $piscineFactory->getPiscineByID($match['id_piscine']);
}

if(!isset($resultat['message'])) {
    $match['mac_date'] = new DateTime($match['mac_date']);
    $resultat['fiche'] = Core_rbp::view('includes/fiche/matchFiche', compact('match', 'piscine'));
}

echo json_encode($resultat);
