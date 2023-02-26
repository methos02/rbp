<?php
if(!is_array($sponsors)) {
    echo Core_rbp::flashHTML('danger', "La variable membre doit être un array") ;
    exit;
}
?>
<?php if(empty($sponsors)): ?>
    <div class="text-center empty-result">
        Cette section n'a pas encore de sonpsor .<br>
        Vous voulez être le premier ? Merci de nous contacter
    </div>
<?php endif; ?>
<?php if(!empty($sponsors)): ?>
    <?php foreach ($sponsors as $sponsor): ?>
        <div class="col-md-4 col-xs-6 text-center" data-id_sponsor="<?= $sponsor['spo_id'] ?>">
            <div class="row"><img src="<?= Sponsor::URL_LOGO.$sponsor['spo_logo'] ?>" class="img-responsive logo-sponsor" style="margin:auto;" alt="logo sponsor"></div>
            <div class="row">
                <h5>
                    <a href="" data-affiche="sponsor"><?= $sponsor['spo_nom'] ?></a>
                    <?= $log['droit'] >= Droit::RESP ? Core_rbp::generateBtnManage('sponsor', $sponsor['spo_id'], '/sponsor_manage/id_sponsor-'.$sponsor['spo_id']): ''; ?>
                </h5>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>