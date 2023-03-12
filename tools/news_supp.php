<?php

use App\Models\News;

include __DIR__.'/../includes/init.php';
$newsFactory = News::factory();
$result['message'] = "";

if ($log['droit'] < Droit::REDAC) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour supprimer une new.");
}

if($result['message'] == "" && (!isset($_POST['id_news']) || !is_numeric($_POST['id_news']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la news est invalide.");
}

if($result['message'] == "") {
    $supp = $newsFactory -> suppNews($_POST['id_news']);

    if($supp == 1){
        $_SESSION['flash'] = Core_rbp::flash('success', "La news a bien été supprimée.");
        $result['success'] = 1;
    } else {
        $result['message'] = Core_rbp::flash('danger', "Aucune news n'a pu être supprimée.");
    }
}

echo json_encode($result);
