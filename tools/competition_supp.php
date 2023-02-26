<?php
include __DIR__.'/../includes/init.php';

$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour supprimer une compétition.");
}

if($result['message'] == "" && !is_numeric($_POST['id_competition'])) {
    $result['message'] = Core_rbp::flash('danger','Ne pas jouer avec les variables.','id competition invalide.');
}

if($result['message'] == "") {
    $update = $competitionFactory->suppCompetition($_POST['id_competition']);

    if($update == 1){
        $result['message'] = Core_rbp::flash('success','La compétition a bien été suprimé');
        $result['success'] = 1;
    } else {
        $result['message'] = Core_rbp::flash('danger','Ne pas jouer avec les variables.','Aucun match ne correspond à l\'id envoyée.');
    }
}

echo json_encode($result);