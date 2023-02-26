<?php
include __DIR__ . '/../includes/init.php';
$photoFactory = Photo::factory();
$Utils = Utils::factory();
$result['message'] = "";
$result['photos'] = [];

if(!isset($_POST['slug']) || !$Utils->checkSlug($_POST['slug'])) {
    $result['message'] = Core_rbp::flash('danger', "Le slug de l'album est invalide.");
}

if($result['message'] == ""){
    $album = $photoFactory->getAlbumBySlug($_POST['slug']);

    if (empty($album)) {
        $result['message'] = Core_rbp::flash('danger', "Le slug ne correspond à aucun l'album.");
    }
}

if ($result['message'] == "") {
    $photos = $photoFactory->getPhotos($album['id_album']);

    if (empty($photos)) {
        $result['message'] = Core_rbp::flash('danger', "L'album est vide.");
    }
}

if($result['message'] == "") {
    foreach ($photos as $photo) {
        if(file_exists('../'.Photo::PHOTO_REAL_PATH.$photo['photo'])) {
            $result['photos'][] = $photo['photo'];
        }
    }
}

echo json_encode($result);