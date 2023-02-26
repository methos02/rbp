<?php
if(!isset($sponsor) || !is_array($sponsor)) {
    echo Core_rbp::flashHTML('danger', "La variable membre doit être un array") ;
    exit;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><strong><?= $sponsor['nom'] ?></strong></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-4">
            <img src="<?= Sponsor::URL_LOGO.$sponsor['logo'] ?>" alt="logo sponsor" class="img-responsive">
        </div>
        <div class="col-xs-8">
            <?php if($sponsor['rue_sponsor'] != null) : ?>
                <h4> Adresse </h4>
                <?= $sponsor['rue_sponsor'].' '.$sponsor['numb_sponsor'] ?><br>
                <?= $sponsor['cp_sponsor'].' '.$sponsor['ville_sponsor'] ?><br>
            <?php endif; ?>
            <?php if($sponsor['tel'] != null) : ?>
                <h4>Téléphone</h4> <?= $sponsor['tel'] ?>
            <?php endif; ?>
            <?php if($sponsor['mail'] != null) : ?>
                <h4>Adresse Mail</h4> <?= $sponsor['mail'] ?>
            <?php endif; ?>
            <?php if($sponsor['site'] != null) : ?>
                <h4> Site internet </h4><a href="http://<?= $sponsor['site'] ?>" target="_blank"><?= $sponsor['site']?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4> Description </h4>
            <?= $sponsor['description'] ?>
        </div>
    </div>
</div>