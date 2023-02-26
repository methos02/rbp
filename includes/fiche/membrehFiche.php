<?php
if(!isset($membre_h) || !is_array($membre_h)) {
    echo Core_rbp::flashHTML('danger', "La variable membre doit être un array") ;
    exit;
}
?>
<div class="row affiche_membre_h">
    <div class="col-md-4 text-center"><img src="<?= Club::URL_PORTRAIT.$membre_h['photo'] ?>" alt="Photo de membre" class="img-responsive img_membre_h"></div>
    <div class="col-md-8">
        <h4>
            <?= $membre_h['nom'].' '.$membre_h['prenom'].$membre_h['date'] ?>
            <?= ($log['droit'] >= Droit::RESP)? Core_rbp::generateBtnManage('membre_h', $membre_h['id_membreH'], '/membreh_manage/id_membreh-' . $membre_h['id_membreH']) : ''; ?>
        </h4>
        <p><?= html_entity_decode($membre_h['bio']) ?></p>
    </div>
</div>