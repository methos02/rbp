<?php
if(!is_array($competition)) {
    echo Core_rbp::flashHTML('danger', "La variable membre doit être un array") ;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <?= $competition['statutLogo']?>
        <?= $competition['nom_competition'] ?>
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-6">
            <strong> Date de la compétition </strong><br>
            <?= $competition['date'] ?>
        </div>
        <div class="col-xs-5 col-xs-offset-1">
            <strong> Rendez-vous </strong><br>
            <?= $competition['heure'] ?> sur place.
        </div>
    </div>
    <?php if(isset($competition['rue_piscine'])) : ?>
        <div class="row">
            <div class="col-xs-12">
                <strong>Lieu</strong><br>
                <?= $competition['rue_piscine'].' '.$competition['numb_piscine'] ?><br>
                <?= $competition['cp_piscine'].' '.$competition['ville_piscine'] ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if($competition['options'] != null) : ?>
        <div class="row">
            <div class="col-xs-12">
                <h3>Documents</h3>
                <form class="form-inline">
                    <div class="input-group">
                        <select title="dl_document" class="form-control" data-download="document"><?= $competition['options'] ?></select>
                        <span class="input-group-btn">
                            <a class="btn btn-default competition-link" href="<?= Competition::FICHIER_URL.$competition['link'] ?>" target="_blank">Télécharger</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>