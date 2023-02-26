<?php
include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$result['message'] = "";

if($log['droit'] < Droit::REDAC){
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits");
}

if($result['message'] == "" && (!isset($_POST['id_album']) || !is_numeric($_POST['id_album']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'album est invalide.");
}

if($result['message'] == "") {
    $album = $photoFactory->getAlbum($_POST['id_album']);

    if(empty($album)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun album ne correspond à l'id renseigné.");
    }

    if($result['message'] == "" && $album['supp'] == 1) {
        $result['message'] = Core_rbp::flash('danger', "L'album est déjà supprimé.");
    }
}

if($result['message'] == "") {
    $photoFactory->suppAlbum($_POST['id_album']);
    $photoFactory->suppPhotos($_POST['id_album']);

    $result['message'] = Core_rbp::flash('success', "L'album a été supprimé.");
    $result['success'] = 1;
}

echo json_encode($result);