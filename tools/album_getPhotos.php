<?php
include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$result['message'] = "";

if ($log['droit'] < Droit::REDAC) {
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits");
}

if ( $result['message'] == ""  && !is_numeric($_POST['id_album'])) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la saison est invalide.");
}

if ( $result['message'] == "" ) {
    $photos = $photoFactory->getPhotos($_POST['id_album']);
    $result['album'] = $photoFactory->getAlbum($_POST['id_album']);
    $result['photos'] = array();

    foreach ($photos as $photo) {
        if(!file_exists('../'.Photo::PHOTO_REAL_PATH.$photo['photo'])) {continue;}

        $size = getimagesize('../'.Photo::PHOTO_REAL_PATH.$photo['photo']);
        $rapport = 120/$size[1];
        $margin = (($size[0] * $rapport) - 120) / 2;

        $result['photos'][] = array('photo' => $photo['photo'], 'size' => filesize('../'.Photo::PHOTO_REAL_PATH.$photo['photo']), 'margin' => -$margin);
    }
}

echo json_encode($result);