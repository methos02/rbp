<?php include __DIR__.'/../includes/init.php';
$generator = new \Ausi\SlugGenerator\SlugGenerator();
$photoFactory = Photo::factory();
$Utils = Utils::factory();
$result['message'] = "";

include('verif/album_verif.php');

if($result['message'] == "") {
    $slug = $generator->generate($_POST['nom']);
    $photoFactory->addAlbum($_POST['nom'], $slug, $_POST['id_saison'], $_POST['id_section']);
    $_SESSION['flash'] = Core_rbp::flash('success', "L'album à bien été créé.");
    $result['url'] = '/photo_manage/' . Section::ID_TO_SLUG[$_POST['id_section']]. '/' . $slug;
}

echo json_encode($result);