<?php
include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$message = "";

if($log['droit'] == Droit::USER){
    $message = "Vous n'avez pas les droits requits";
}

if($message == "" && (!isset($_POST['id_album']) || !is_numeric($_POST['id_album']))) {
    $message = "L'id de l'album est invalide.";
}

if($message == "" && $_FILES['file']['error'] !== 0){
    $message = "Erreur image n°" . $_FILES['file']['error'] . ' - ' . Photo::ERREUR[$_FILES['file']['error']];
}

if ($message == "" && !is_dir('../'.Photo::PHOTO_REAL_PATH)) {
    $message = "Le chemin pour enregistré les photos est invalide.";
}

if ($message == "" && !in_array(strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg'])) {
    $message = "Extention de la photo invalide.";
}

if ($message == "") {
    $album = $photoFactory->getAlbum($_POST['id_album']);

    if ( empty($album)) {
        $message = "Aucun album ne correspond à l'id fournie.";
    }
}

if($message != "") {
    http_response_code(500);
    echo $message;
    exit;
}

if($message == "") {
    $result['photo'] = $photoFactory -> move_file('file', Photo::PHOTO_REAL_PATH);

    //redimention de l'image
    if($_FILES['file']['size'] > Photo::SIZE_MAX) {
        $img = __DIR__ . '/../' .Photo::PHOTO_REAL_PATH.$result['photo'];

        list($width, $height, $type, $attr) = getimagesize($img);

        $new_size = $photoFactory->defineNewSize($width, $height, filesize ($img), Photo::SIZE_MAX );
        $photoFactory->resize($img, $new_size['width'], $new_size['height'], $width, $height);
    }

    //Vérification cover
    if(empty($album['cover'])){
        $photoFactory -> definePhotoCover($_POST['id_album'], $result['photo']);
        $result['cover'] = 1;
    }

    $photoFactory->addPhoto($result['photo'], $_POST['id_album']);
}

echo json_encode($result);