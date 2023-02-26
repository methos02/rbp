<table data-table="competitions">
    <tr>
        <th></th>
        <th> Date </th>
        <th> Nom </th>
        <?= $id_section == Section::NATATION['id'] ? '<th class="hidden-xs hidden-sm"> Liste nageurs </th><th class="hidden-xs hidden-sm"> Programme </th>': '' ?>
        <th class="hidden-xs hidden-sm"> Résultat </th>
        <?= $log['droit'] >= Droit::RESP ? '<th class="hidden-xs hidden-sm"> Modifier / Supprimer </th>': ''; ?>
    </tr>
    <?php foreach ($competitions as $competition) : ?>
        <tr data-id_competition="<?= $competition['com_id'] ?>">
            <td> <?= $competition['statutLogo'] ?></td>
            <td> <?= $competition['date'] ?></td>
            <td> <a href="" class="affiche-competition"><?= $competition['com_nom'] ?></a></td>
            <?= $competition['dl_liste'] ?>
            <?= $competition['dl_programme'] ?>
            <?= $competition['dl_resultat'] ?>
            <?php if($log['droit'] >= Droit::RESP): ?>
                <td class="text-center hidden-xs hidden-sm td-modif"><?= Core_rbp::generateBtnManage('competition', $competition['com_id'] )?> </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>