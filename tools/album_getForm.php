<?php include __DIR__.'/../includes/init.php';
$factoryPhoto = Photo::factory();
$saisonFactory = Saison::factory();
$result['message'] = "";
$album = [];

if( isset($_POST['id_album'])) {
    if(!is_numeric($_POST['id_album'])) {
        $result['message'] = Core_rbp::flash("danger","L'id est invalide");
    }

    if($result['message'] == "") {
        $album = $factoryPhoto->getAlbum($_POST['id_album']);

        if(empty($album)) {
            $result['message'] = Core_rbp::flash("danger","Aucun album ne correspond à l'id renseignée.");
        }
    }
}

if($result['message'] == "") {
    $id_section = isset($album['id_section']) ? $album['id_section'] : null;
    $id_saison = isset($album['id_saison']) ? $album['id_saison'] : null;
    $id_album = isset($album['id_album']) ? $album['id_album'] : null;
    $saisons = $saisonFactory->getSaisons();

    $formAlbum = Form::factoryForm($album);
    $result['form'] = Core_rbp::view('includes/form/albumForm', compact('formAlbum', 'id_section', 'id_saison', 'id_album', 'saisons'));
}

echo json_encode($result);