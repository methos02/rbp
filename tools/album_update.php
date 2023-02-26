<?php include __DIR__.'/../includes/init.php';
$generator = new \Ausi\SlugGenerator\SlugGenerator();
$Utils = Utils::factory();
$photoFactory = Photo::factory();
$result['message'] = "";

if($result['message'] == "" && (!isset($_POST['id_album']) || !is_numeric($_POST['id_album']) )) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'album est invalide.");
}

if($result['message'] == "") {
    include('verif/album_verif.php');
}

if($result['message'] == "" && $_POST['id_album'] != "") {
    $album = $photoFactory->getAlbum($_POST['id_album']);

    if(empty($album)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun album ne correspond à l'id fournie.");
    }
}

if($result['message'] == "") {
    $slug = $generator->generate($_POST['nom']);
    $photoFactory->updateAlbum($_POST['id_album'], $_POST['nom'], $slug, $_POST['id_saison'], $_POST['id_section']);
    $_SESSION['flash'] = Core_rbp::flash('success', "L'album à bien été modifié.");
    $result['url'] = '/photo_manage/' . Section::ID_TO_SLUG[$_POST['id_section']]. '/' . $slug;
}

echo json_encode($result);