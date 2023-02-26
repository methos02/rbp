<?php
if(!isset($formAlbum) || !$formAlbum instanceof Form) {
    echo Core_rbp::flashHTML('danger', "La variable form est invalide.") ;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= isset($id_album) && $id_album != null? "Modifier l'": 'Ajouter un '; ?>album</h4>
    <div id="modal-message"></div>
</div>
<div class="modal-body">
    <form name="form-album" class="form-album">
        <?= isset($id_album) && $id_album != null? '<input type="hidden" name="id_album" value="'.$id_album.'">': ""; ?>
        <?= $formAlbum->titre('nom', 'Nom :', ['obliger' => 1])?>
        <div class="row-flex">
            <?= $formAlbum -> select('id_saison', 'Saison :', Saison::factory()->idToSaison($saisons), ['obliger' => 1, 'default' => $id_saison])?>
            <?= $formAlbum -> select('id_section', 'Section :', Section::ID_TO_NAME, ['obliger' => 1, 'default' => $id_section])?>
        </div>
        <button type="submit" class="btn btn-primary submit-compact" name="submit" data-verif="form-album"> Enregistrer </button>
    </form>
</div>