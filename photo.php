<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$photoFactory = Photo::factory();
$saisonFactory = Saison::factory();
$Utils = Utils::factory();
$form = Form::factoryForm();
$message = "";

if(isset($_GET['album']) && !$Utils->checkSlug($_GET['album'])) {
    $message = "Le slug est invalide.";
}

if($message == "" && isset($_GET['album'])) {
    $album = $photoFactory->getAlbumBySlug($_GET['album']);

    if(empty($album)) {
        $message = "Le slug ne correspond à aucun album";
    }

    if($message == "") {
        $album = $photoFactory->getAlbum($album['id_album']);
    }
}

if($message == "" && isset($_GET['section']) && !isset(Section::SLUG_TO_ID[$_GET['section']])){
    $message = "La section est invalide.";
}

if(isset($album['id_section'], $_GET['section']) && $_GET['section'] != Section::ID_TO_SLUG[$album['id_section']]) {
    header('location:/photo/'. Section::ID_TO_SLUG[$album['id_section']] .'/'.$album['slug']);
    exit;
}

if($message != "") {
    $_SESSION['flash'] = Core_rbp::flash('danger', $message);
}

$id_section = ($message == "" && isset($_GET['section']))? Section::SLUG_TO_ID[$_GET['section']] : Section::COMITE['id'];
$id_saison = (isset($album['id_saison']))? $album['id_saison'] : $photoFactory->getLastSaisonAlbum($id_section);

$saisons = $saisonFactory->getSaisonAlbumBySection($id_section);
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);

if($message == "") {
    $albums = $photoFactory->getAlbumsBySaison_Section($id_saison , $id_section);
    $orderAlbums = $photoFactory->orderAlbum($albums);
}

//définition des select section et saison
$etat_selectSaison = (isset($albums) && empty($albums))? 'disabled="disabled"' : '';
?>
<!DOCTYPE html>
<html>
    <?php include("includes/head.php"); ?>
    <body class="heigh_photo">
        <?php include("includes/header.php"); ?>
        <div class="navbar-default navbar-fixed-top navbar-secondaire">
            <?php if($log['droit'] > Droit::USER ): ?>
                <div class="navbar-form navbar-left">
                    <a href="/photo_manage/<?= Section::ID_TO_SLUG[$id_section] ?>" class="btn btn-primary" data-modif="photos"> Ajouter des photos</a>
                </div>
            <?php endif; ?>
            <form class="form-inline navbar-right navbar-form">
                <div class="input-group">
                    <span class="input-group-btn reference">
                        <select name="photo_sSection" id="photo_sSection" class="form-control input-rbp">
                            <?= $form->defineOptions(Section::SLUG_TO_NAME, ['default' => Section::ID_TO_SLUG[$id_section]])?>
                        </select>
                        <label for="photo_sSection" class="label-rbp">1. Section </label>
                    </span>
                    <span class="input-group-btn reference">
                        <select name="photo_idSaison" id="photo_idSaison" class="form-control input-group-select input-rbp" <?php echo $etat_selectSaison ?>>
                            <?= $form->defineOptions($arrSaiIdToSaison, ['default' => $id_saison])?>
                        </select>
                        <label for="photo_idSaison" class="label-rbp">2. Saison </label>
                    </span>
                </div>
            </form>
        </div>
        <div class="container-fluid contenu contenu-photo"><?php if(isset($orderAlbums)) {echo $orderAlbums;} ?></div>
        <?php include("includes/footer.php"); ?>
        <div id="album" <?= isset($album['slug'])? 'data-slug="'. $album['slug'] . '"' : ''; ?>> </div>
        <?php include("includes/script.php"); ?>
        <script>
            $(function() {
                let slug = $('#album').data('slug');

                 if( slug !== undefined) {
                    afficheAlbum(slug);
                    let section = $('#photo_sSection').val();
                    history.replaceState({}, "", "/photo/" + section);
                }
            });
        </script>
    </body>
</html>
