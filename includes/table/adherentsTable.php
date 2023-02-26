<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th> Statut </th>
        <th> Nom </th>
        <th> Prenom </th>
        <th> Date de naissance </th>
        <th class="text-center"><?= $saisonActive == $id_saison ? 'Modifier' : 'Réinscrire' ?></th>
    </tr>
    <?php foreach($adherents as $adherent) : ?>
        <tr data-id_ads="<?= $adherent['id_ads'] ?>">
            <td style="background:<?= $adherent['color_divPicto'] ?>" >
                <?php if($adherent['licence'] == 0) { echo Core_rbp::icon('file', 'black');} ?>
                <?php if($adherent['certif'] == 0) { echo Core_rbp::icon('heart', 'black');} ?>
                <?php if($adherent['cotisation'] == 0) { echo Core_rbp::icon('usd', 'black');} ?>
                <?php if(empty($adherent['rue_1'])) { echo Core_rbp::icon('home', 'black');} ?>
                <?php if(!$adherent['verifMail']) { echo Core_rbp::icon('globe', 'black');} ?>
                <?php if(!$adherent['verifTel']) { echo Core_rbp::icon('phone', 'black');} ?>
            </td>
            <td> <a href="#" data-affiche="adherent"><?= $adherent['nom'] ?></a></td>
            <td><?= $adherent['prenom'] ?></td>
            <td><?= $adherent['date_birth'] instanceof DateTime ? $adherent['date_birth']->format('d-m-Y'): '' ?></td>
            <td class="td-supp">
                <?= $saisonActive == $id_saison && $adherent['preinscrit'] != 1 ? '<a href="#" data-action="preinscrire" data-id_adherent="' . $adherent['id_adherent'] . '">' . Core_rbp::icon('file', 'blue') . '</a>' : ''; ?>
                <?= $saisonActive == $id_saison ? Core_rbp::generateBtnManage('adherent', $adherent['id_ads'], '/adherent_manage/id_ads-' . $adherent['id_ads']) : '' ?>
                <?= $saisonActive != $id_saison && $adherent['inscrit'] != 1 ? Core_rbp::generateConfirmeBtn('file', 'blue', 'data-action="reinscrire" data-id_adherent="' . $adherent['id_adherent']. '"')  : ''; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>