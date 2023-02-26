<?php include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$result['message'] = "";

if($log['droit'] == Droit::USER){
    $result['message'] = Core_rbp::flash('danger',"Vous n'avez pas les droits requits pour afficher la liste des albums.");
}

if($result['message'] == "" && (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison']))){
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");
}

if($result['message'] == "" && (!isset($_POST['s_section']) || !isset(Section::SLUG_TO_ID[$_POST['s_section']]))){
    $result['message'] = Core_rbp::flash('danger', "Le slug de la saison est invalide.");
}

if($result['message'] == "") {
    $albums = $photoFactory->getAlbumsBySaison_Section($_POST['id_saison'], Section::SLUG_TO_ID[$_POST['s_section']]);

    if(empty($albums)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun album trouvé pour cette section.");
    }
}

if($result['message'] == "") {
    $result['liste'] = $photoFactory->orderListeAlbum($albums);
}

echo json_encode($result);