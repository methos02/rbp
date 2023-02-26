<?php include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Préinscription';
$adherentFactory = Adherent::factory();

$ids_adherent = $adherentFactory->getPreinscription();

if (!empty($ids_adherent)) {
    $adherents = $adherentFactory->getAdherents($ids_adherent, ['multi' => true]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include("includes/head.php"); ?>
<body class="body-flex">
<?php include("includes/header.php"); ?>
<div class="navbar navbar-default navbar-secondaire navbar-fixed-top">
   <?php include ('includes/header/adherentNavbar.php') ?>
</div>
<div class="container">
    <h2>Adhérents Préinscrit</h2>
    <div data-div="preinscrits">
        <?php if(!empty($adherents)) : ?>
            <table class="table table-bordered table-striped table-condensed">
                <tr>
                    <th> Nom </th>
                    <th> Prenom </th>
                    <th> Date de naissance </th>
                    <th> Préinscription</th>
                </tr>
                <?php foreach($adherents as $adherent) : ?>
                    <tr data-id_ads="<?= $adherent['id_ads'] ?>">
                        <td><?= $adherent['nom'] ?></td>
                        <td><?= $adherent['prenom'] ?></td>
                        <td><?=  (new DateTime($adherent['date_birth']))->format('d-m-Y') ?></td>
                        <td class="td-supp"> <?= Core_rbp::generateConfirmeBtn('remove', 'red', 'data-supp="preinscrire" data-id_adherent="' . $adherent['id_adherent'] . '"'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif;?>
        <?php if(empty($adherents)) : ?>
            <?= Core_rbp::emptyResult("Il n'y a aucun adhérent préinscrit.") ?>
        <?php endif ; ?>
    </div>
</div>
<?php include("includes/footer.php"); ?>
<div class="modal fade" id="Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<?php include("includes/script.php"); ?>
</body>
</html>