<?php

use App\Core\Core_rbp;

include __DIR__.'/../includes/init.php';
$id_saison = Saison::factory()->saisonActive(false);
$matchFactory = MatchM::factory();

if (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison'])) {
    $result['message'] = ['danger',"L'id de la saison est invalide."];
}

if (!isset($result['message']) && (!isset($_POST['id_categorie']) || !is_numeric($_POST['id_categorie']))) {
    $result['message'] = ['danger',"L'id de la categorie est invalide."];
}

if(!isset($result['message'])) {
    $matchs = $matchFactory->getCalendrier($_POST['id_saison'], $_POST['id_categorie']);

    if(empty($matchs)) {
        $result['message'] = ['danger',"Aucun match trouvé."];
    }
}

if(!isset($result['message'])) {
    $matchs = $matchFactory->setsParams($matchs, $id_saison);
    $result['calendrier'] = Core_rbp::view('includes/table/matchsTable', compact('matchs'));
}

echo json_encode($result);
