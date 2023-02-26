<?php include __DIR__ . '/../includes/init.php';
$matchFactory = Match::factory();
$piscineFactory = Piscine::factory();
$resultat['message'] = "";

if (!isset($_POST['id_match']) || !is_numeric($_POST['id_match'])) {
    $resultat['message'] = Core_rbp::flash('danger',"L'id match invalide.");
}

if ($resultat['message'] == "") {
    $match = $matchFactory->getMatch($_POST['id_match']);

    if ( empty($match)) {
        $resultat['message'] = Core_rbp::flash('danger',"Aucun match ne correspond à l'id envoyée.");
    }
}

if($resultat['message'] == "" && $match['id_piscine'] != null){
    $piscine = $piscineFactory->getPiscineByID($match['id_piscine']);
}

if($resultat['message'] == "") {
    $match['mac_date'] = new DateTime($match['mac_date']);
    $resultat['fiche'] = Core_rbp::view('includes/fiche/matchFiche', compact('match', 'piscine'));
}

echo json_encode($resultat);