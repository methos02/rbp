<?php use App\Core\Form;

include __DIR__.'/../includes/init.php';
$photoFactory = Photo::factory();
$saisonFactory = Saison::factory();
$form = Form::factoryForm();
$result['message'] = "";
$albums = "";

if(!isset($_POST['s_section']) || !isset(Section::SLUG_TO_ID[$_POST['s_section']])) {
    $result['message'] = Core_rbp::flash('danger', "Le slug de la section est invalide.");
}

if ($result['message'] == "") {
    $saisons = $saisonFactory->getSaisonAlbumBySection(Section::SLUG_TO_ID[$_POST['s_section']]);

    if(empty($saisons)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun album trouvé pour cette section.");
    }
}

if($result['message'] == "") {
    $arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);
    $result['saison'] = $form->defineOptions($arrSaiIdToSaison, ['default' => $saisons[0]['sai_ID']]);
    $albums = $photoFactory->getAlbumsBySaison_Section($saisons[0]['sai_ID'], Section::SLUG_TO_ID[$_POST['s_section']]);
    $result['albums'] = $photoFactory->orderAlbum($albums);
    $result['liste'] = $photoFactory->orderListeAlbum($albums);
    $result['success'] = 1;
}

echo json_encode($result);
