<?php
include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$result['message'] = "";

if ($log['droit'] < Droit::REDAC) {
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits");
}

if ($result['message'] == "" && !isset($_POST['nom'])) {
    $result['message'] = Core_rbp::flash('danger', "Nom de la photo invalide.");
}

if ($result['message'] == "" && (!isset($_POST['id_album']) || !is_numeric($_POST['id_album']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'album est invalide.");
}

if ($result['message'] == "") {
    $photo = $photoFactory->getPhotoByName($_POST['nom']);

    if ( empty($photo)) {
        $result['message'] = Core_rbp::flash('danger', "La photo est introuvable.");
    }
}

if ($result['message'] == "") {
    $album = $photoFactory->getAlbum($_POST['id_album']);

    if (empty($album)) {
        $result['message'] = Core_rbp::flash('danger', "L'id de l'album est invalide.");
    }
}

if($result['message'] == "") {
    $photoFactory->definePhotoCover($_POST['id_album'], $_POST['nom']);
    $result['message'] = Core_rbp::flash('success', 'Couverture changée');
    $result['success'] = 1;
}

echo json_encode($result);