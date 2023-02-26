<table id="wp_calendrier">
    <thead>
    <tr>
        <th> Date </th>
        <th><span class="hidden-xs">Club visité</span><span class="visible-xs">Visité</span></th>
        <th> Score </th>
        <th><span class="hidden-xs">Club visiteur</span><span class="visible-xs">Visiteur</span></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($matchs as $match) : ?>
        <tr class="<?= $match['color'] ?>" data-id_match="<?= $match['mac_id'] ?>">
            <td class="date-match">
                <span class="span-date">
                    <span><?= $match['mac_date'] instanceof DateTime? $match['mac_date']->format('d/m'): '' ?></span>
                    <span> - </span>
                    <span><?= $match['mac_date'] instanceof DateTime? $match['mac_date']->format('H\hi'): '' ?></span>
                </span>
                <?= $match['mac_coupe'] == 1 ? '<img src="/img/coupe.png" alt="icone de la coupe" class="xs-icone">' : '' ?>
            </td>
            <td><?= $match['init_in'] ?> <span class="hidden-xs"><?= $match['club_in'] ?></span></td>
            <td class="text-center td-score"><?=  $match['score'] ?></td>
            <td class="text-right"><?= $match['init_out'] ?> <span class="hidden-xs"><?= $match['club_out'] ?></span></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>