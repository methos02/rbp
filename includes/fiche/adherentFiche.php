<?php
if(!is_array($adherent)) {
    echo Core_rbp::flashHTML('danger', "La variable Adhérent doit être un array") ;
    exit;
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        <?php foreach($adherent['categories'] as $id_section => $fonctions): ?> <img src="/images/picto_<?= $id_section ?>.png" alt="Picto de section"><?php endforeach; ?>
        <?= $adherent['nom'].' '.$adherent['prenom'].' ('. ($adherent['date_birth'] instanceof DateTime ? $adherent['date_birth']->format('d/m/Y') : '' ).')' ?>
    </h4>
</div>
<div class="modal-body">
    <p>Nationalité: <?= $adherent['nationalite'] ?></p>
    <?php if($adherent['rue_1'] != '') : ?>
        <div>
            <h3> Adresse Principale</h3>
            <p><?= $adherent['numb_1']. ' '.$adherent['rue_1'] ?></p>
            <p><?= $adherent['cp_1'].' '.$adherent['ville_1'] ?></p>
        </div>
    <?php endif; ?>
    <?php if($adherent['rue_2']!= ""): ?>
        <div>
            <h3> Seconde adresse</h3>
            <p><?= $adherent['numb_2']. ' '.$adherent['rue_2'] ?></p>
            <p><?= $adherent['cp_2'].' '.$adherent['ville_2'] ?></p>
        </div>
    <?php endif; ?>
    <?php if($adherent['verifTel']) : ?>
        <h3> Téléphone </h3>
        <div class="div-mails">
            <?php if(!empty($adherent['tel'])):?><span class="adherent-items"> Téléphone fixe: <?= $adherent['tel'] ?></span><?php endif; ?>
            <?php if(!empty($adherent['gsm'])):?><span class="adherent-items">GSM du membre: <?= $adherent['gsm'] ?> </span><?php endif; ?>
            <?php if(!empty($adherent['gsm_mere'])):?><span class="adherent-items"> GSM de la mère: <?= $adherent['gsm_mere'] ?></span><?php endif; ?>
            <?php if(!empty($adherent['gsm_pere'])):?><span class="adherent-items">GSM du père: <?= $adherent['gsm_pere'] ?></span><?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if($adherent['verifMail']) : ?>
        <h3> Adresse Mail </h3>
        <div class="adherent-mails">
            <?php if(!empty($adherent['mail'])):?><span class="adherent-items"> Mail de l'adherent: <?= $adherent['mail'] ?></span><?php endif;?>
            <?php if(!empty($adherent['mail_mere'])):?><span class="adherent-items"> Mail de la mère: <?= $adherent['mail_mere'] ?></span><?php endif; ?>
            <?php if(!empty($adherent['mail_pere'])):?><span class="adherent-items"> Mail du père: <?= $adherent['mail_pere'] ?></span><?php endif; ?>
        </div>
    <?php endif; ?>
    <h3> Information club </h3>
    <?php foreach ($adherent['categories'] as $id_section => $fonctions): ?>
        <h4><?= Section::ID_TO_NAME[$id_section]?></h4>
        <?php foreach($fonctions as $id_fonction => $categories) :?>
            <ul>
                <li>
                    <?= Database::FON_ID_TO_NAME[$id_fonction] ?> :
                    <?php foreach ($categories as $categorie) : ?>
                        <span class="adherent-cat"><?= $categorie ?></span>
                    <?php endforeach; ?>
                </li>
                <?php if(in_array(array('id_section' => $id_section), $adherent['cs'])):?> <li> Membre du Cs.</li> <?php endif; ?>
            </ul>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <?php if($adherent['licence'] == 1): ?>
        <h3> Information compétition </h3>
        <?php if($adherent['id_licence'] != Database::L_NON_INFO): ?>
            <p>
                Type de licence: <?= Database::L_ID_TO_LABEL[$adherent['id_licence']] ?>
                <?= $adherent['numb_licence'] != "" ? ' n° de licence: '.$adherent['numb_licence'] : '' ?>
            </p>
            <?= $adherent['date_licence'] != "00/00/0000" ? '<p> Date de la licence: ' . $adherent['date_licence'] . '</p>' : ''; ?>
        <?php endif; ?>
        <?php if($adherent['date_certif'] != "00/00/0000"): ?>
            <h3> Certificat médical </h3>
            <p> Date du certificat médical: <?= $adherent['date_certif'] ?></p>
        <?php endif; ?>
    <?php endif; ?>
    <h3> Information cotisation </h3>
    <p>Montant de la cotisation: <?= Database::COT_ID_TO_LABEL[$adherent['id_cotisation']] ?></p>
    <?php if (!in_array($adherent['id_cotisation'],Database::ARRAY_NO_COT)) : ?>
        <?php if ($adherent['date_cotisation'] != "00/00/0000") : ?><p> Date de cotisation: <?= $adherent['date_cotisation'] ?></p><?php endif; ?>
        <?php if ($adherent['montant'] != '') : ?><p> Montant perçu: <?= $adherent['montant'] ?> € </p><?php endif; ?>
        <?php if ($adherent['montant'] == '') : ?><p>Aucun montant perçu </p><?php endif; ?>
    <?php endif; ?>
</div>
