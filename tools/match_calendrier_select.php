<?php

use App\Core\Core_rbp;

include __DIR__.'/../includes/init.php';
$matchFactory = MatchM::factory();
$id_saison = Saison::factory()->saisonActive(false);
$result['message'] = "";

if(!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison'])) {
    $result['message'] = Core_rbp::flash('danger',"L'id saison invalide.");
}

if($result['message'] == "") {
    $matchs = $matchFactory ->getCalendrier($_POST['id_saison'], '17');

    if(empty($matchs)) {
        $result['message'] = Core_rbp::flash('danger',"Aucun match trouvé.");
    }
}

if($result['message'] == '') {
    $matchs = $matchFactory->setsParams($matchs, $id_saison);
    $result['calendrier'] = Core_rbp::view('includes/table/matchsTable', compact('matchs'));
    $result['btn']= Core_rbp::getCategorieBtn($_POST['id_saison'], '17');
}

echo json_encode($result);
