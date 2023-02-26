<?php include __DIR__.'/includes/init.php';
$Utils = Utils::factory();
$form = Form::factoryForm();
$photoFactory = Photo::factory();
$saisonFactory = Saison::factory();
$message = "";

//Paramètre personnel
if ($log['droit'] < Droit::RESP) {
    $_SESSION['flash'] = Core_rbp::flash('danger', 'Accès interdit', 'Vous devez être connecté pour accéder à cette page');
    header('location:/accueil');
    exit;
}

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
    header('location:/photo_manage/'. Section::ID_TO_SLUG[$album['id_section']] .'/'.$album['slug']);
    exit;
}

if($message != "") {
    $_SESSION['flash'] = Core_rbp::flash('danger', $message);
}

$id_section = isset($_GET['section']) && $message == "" ? Section::SLUG_TO_ID[$_GET['section']]: Section::COMITE['id'];

$saisons = $saisonFactory->getSaisonAlbumBySection($id_section);
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);

$id_saison = isset($album['id_saison'])? $album['id_saison'] : $photoFactory->getLastSaisonAlbum($id_section);

$albums_liste = "";
if(!empty($id_saison)) {
    $albums = $photoFactory->getAlbumsBySaison_Section($id_saison , $id_section);
    $albums_liste = $photoFactory->orderListeAlbum($albums);
}

//Placer le footer au bottom de la page
$footer = 'class="footer-bottom"';
$etat_selectSaison = empty($saisons)? 'disabled="disabled"' : '';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <?php include("includes/head.php"); ?>
    <body>
        <div class="div-principale">
            <?php include("includes/header.php"); ?>
            <div class="navbar navbar-default navbar-fixed-top navbar-secondaire">
                <div class="navbar-form navbar-right hidden-xs">
                    <button class="btn btn-primary" data-manage="album"> Nouvel Album </button>
                </div>
            </div>
            <div class="contenu container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <h4>Les albums </h4>
                            <div class="input-group">
                                <span class="input-group-btn reference">
                                    <select name="liste_sSection" id="liste_sSection" class="form-control input-rbp">
                                        <?= $form->defineOptions(Section::SLUG_TO_NAME, ['default' => $_GET['section']])?>
                                    </select>
                                    <label for="liste_sSection" class="label-rbp">1. Section </label>
                                </span>
                                <span class="input-group-btn reference">
                                    <select name="id_saison" id="liste_id_saison" class="form-control input-group-select input-rbp" <?= $etat_selectSaison ?>>
                                        <?= $form->defineOptions($arrSaiIdToSaison, ['default' => $id_saison])?>
                                    </select>
                                    <label for="liste_id_saison" class="label-rbp">2. Saison </label>
                                </span>
                            </div>
                        </div>
                        <div id="list_album"><?= $albums_liste; ?></div>
                    </div>
                    <div class="col-md-9">
                        <div id="alubm-title" <?= isset($album['id_album']) ? 'data-id_album="' . $album['id_album'] . '"' : '';?> ></div>
                        <form action="/t-photo_upload" class="dropzone row-pad" id="photoupload" style="display: none">
                            <input type="hidden" name="id_album" value="">
                        </form>
                    </div>
                </div>
                <div id="template-preview" style="display: none">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image"><img data-dz-thumbnail="" src="/img/fond_gris.jpg" alt="thumbnail"></div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-success-mark"><img src="/img/success_icon.png" alt="icone success"></div>
                        <div class="dz-error-mark"><img src="/img/error_icon.png" alt="icone erreur"></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        <span class="btn-modif"  data-groupe="supp">
                            <button class="dz-btn-ask btn btn-default" data-change="supp"> Supprimer </button>
                        </span>
                        <span  data-groupe="supp" style="display: none">
                            <button class="dz-btn-confirme btn btn-success" data-dz-remove> Oui </button>
                            <button class="dz-btn-confirme btn btn-danger" data-change="supp"> Non </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" data-div="albumForm"></div>
                </div>
            </div>
            <?php include("includes/footer.php"); ?>
        </div>
        <?php include("includes/script.php"); ?>
        <script src="/dropzone.js"></script>
        <script>
            Dropzone.autoDiscover = false;

            $(function(){
                $('#photoupload').dropzone({
                    acceptedFiles: 'image/*',
                    previewTemplate: document.querySelector('#template-preview').innerHTML,
                    init: function() {
                        let dropzone = this;

                        $(document).on('click', 'li[data-id_album]', function(e){
                            e.preventDefault();
                            if($(e.target).is('span[class*=glyphicon]')) {return;}
                            getAlbum($(this).data('id_album'));
                        });

                        let id_album = $('#alubm-title').data('id_album');
                        if (id_album !== undefined) {
                            getAlbum(id_album);
                            let s_section = window.location.pathname.split('/')[2];
                            history.replaceState({}, "", "/photo_manage/" + s_section);
                        }

                        function getAlbum(id_album) {
                            $('.dz-preview').remove();

                            $.post('/t-album_getPhotos', {id_album:id_album}, function(data){
                                if( data.message !== "") {
                                    $('.message').html(data.message);
                                    $('#message-flash').fadeIn();
                                    return;
                                }

                                if(data.photos.length !== 0) {
                                    $.each(data.photos, function(key, value) {
                                        var mockFile = {name:value.photo, size:value.size};

                                        dropzone.emit("addedfile", mockFile);
                                        dropzone.emit("thumbnail", mockFile, '/images/photo/' + value.photo);
                                        dropzone.files.push(mockFile);
                                        dropzone.emit("complete", mockFile);

                                        var this_img = $('img[src="/images/photo/' + value.photo + '"]');
                                        this_img.css({'height':'120px', 'margin-left': value.margin});

                                        if(value.photo === data.album.cover) {
                                            this_img.parent('div').css('border','4px solid #e2ba4a');
                                        }
                                    });

                                    $('.dz-message').hide();
                                } else {
                                    $('.dz-message').show();
                                }

                                $('input[name=id_album]').val(id_album);
                                $('#alubm-title').html('<h2>' + data.album.nom + '</h2>');

                            }, 'json');

                            $('form[id=album] button').html('Modifier');
                            $('#photoupload').show();
                        }
                    },

                    success:function(file, data) {
                        let json = JSON.parse(data);
                        let $element = $(file.previewElement);

                        $element.find('img').attr('alt',json.photo);
                        $element.addClass('dz-upload-complete');

                        if(json.cover === 1) {
                            $element.find('.dz-image').css('border','4px solid #e2ba4a');
                        }
                    },

                    removedfile: function (file) {
                        let nom = $(file.previewTemplate).find('img').attr('alt');

                        $.post('/t-photo_supp', {nom:nom}, function(data){
                            $('.message').html(data.message);
                            $('#message-flash').fadeIn();

                            if(data.success === 1){
                                file.previewElement.remove();
                            }
                        }, 'json');
                    },

                    error : function(file, errorMessage) {
                        let $element = $(file.previewElement);
                        $element.find('.dz-error-message').html(errorMessage);
                        $element.addClass('dz-error');
                        $element.find('span[data-groupe=supp]').hide();
                    }
                });
            });
        </script>
    </body>
</html>
