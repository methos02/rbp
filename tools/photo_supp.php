<?php
include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$result['message'] = "";

if($log['droit'] == Droit::REDAC){
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits");
}

if($result['message'] == "" && !isset($_POST['nom'])) {
    $result['message'] = Core_rbp::flash('danger', "Nom de photo manquante.");
}

//Vérfication que la photo n'est pas une couverture
if($result['message'] == "") {
    $photo = $photoFactory->getPhotoAndAlbumCoverByName($_POST['nom']);

    if (empty($photo)) {
        $result['message'] = Core_rbp::flash('danger', "Aucune photo ne correspond au nom fourni.");
    }

    if ($result['message'] == "" && $photo['alb_cover'] == $_POST['nom']) {
        $result['message'] = Core_rbp::flash('danger', "La photo est une couverture","Veuillez sélectionner une autre couverture avant de supprimer cette photo.");
    }
}

if($result['message'] == "") {
    $supp = $photoFactory->suppPhoto(htmlspecialchars($_POST['nom']));
    $result['message'] = Core_rbp::flash('success', "La photo a été supprimée.");
    $result['success'] = 1;
}

echo json_encode($result);