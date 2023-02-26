<?php
if(!isset($match) || !is_array($match) || !isset($piscine) || !is_array($piscine)) {
    echo Core_rbp::flashHTML('danger', "Paramètres de la vue match invalide.") ;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <?php if($match['mac_coupe'] == 1) : ?>
            <img src="/img/coupe.png" alt="icone de coupe">
        <?php endif; ?>
        <?= ' ' . $match['club_in'] . ' - ' . $match['club_out'] ?>
    </h4>
</div>
<div class="modal-body">
    <?php if($match['mac_coupe'] == 1) { echo '<div class="margin-bot"><strong> Match de coupe de belgique </strong></div>';} ?>
    <div class="row">
        <div class="col-sm-12">
            <strong> Date du match : </strong> <?= $match['mac_date']->format('d/m/Y').' - '.$match['mac_date']->format('H\hi') ?>
        </div>
        <?php if (!empty($match['mac_arbitre'])) : ?>
            <div class="col-sm-12">
                <strong> Arbitre<?= strpos($match['mac_arbitre'], '-') !== false ? 's' : '' ;?> : </strong> <?= $match['mac_arbitre'] ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <strong> N° de match : </strong> <?= $match['numb_match'] ?>
        </div>
    </div>
    <?php if($piscine != null) : ?>
        <div class="row-column">
            <strong> Adresse :</strong>
            <span><?= $piscine['nom_piscine'] ?></span>
            <span><?= $piscine['rue_piscine'].' '.$piscine['numbRue_piscine'] .' - '. $piscine['cp_piscine'].' '.$piscine['ville_piscine']?></span>
        </div>
    <?php endif; ?>
</div>
