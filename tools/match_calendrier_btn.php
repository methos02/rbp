<?php

use App\Core\Core_rbp;

include __DIR__.'/../includes/init.php';
$id_saison = Saison::factory()->saisonActive(false);
$matchFactory = MatchM::factory();
$result['message'] = "";

if (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison'])) {
    $result['message'] = Core_rbp::flash('danger',"L'id de la saison est invalide.");
}

if ($result['message'] == "" && (!isset($_POST['id_categorie']) || !is_numeric($_POST['id_categorie']))) {
    $result['message'] = Core_rbp::flash('danger',"L'id de la categorie est invalide.");
}

if($result['message'] == '') {
    $matchs = $matchFactory->getCalendrier($_POST['id_saison'], $_POST['id_categorie']);

    if(empty($matchs)) {
        $result['message'] = Core_rbp::flash('danger',"Aucun match trouvé.");
    }
}

if($result['message'] == '') {
    $matchs = $matchFactory->setsParams($matchs, $id_saison);
    $result['calendrier'] = Core_rbp::view('includes/table/matchsTable', compact('matchs'));
}

echo json_encode($result);
