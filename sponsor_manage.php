<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$sponsorFactory = Sponsor::factory();
$message = "";
$sponsor = "";

if ($log['droit'] < Droit::RESP ) {
	$message = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
}

if (isset($_GET['id_sponsor']) && !is_numeric($_GET['id_sponsor'])) {
    $message = Core_rbp::flash('danger', 'L \'ID du sponsor est invalide');
}

if ($message == "" && isset($_GET['id_sponsor'])) {
    $sponsor = $sponsorFactory->getSponsor($_GET['id_sponsor']);

    if (empty($sponsor)) {
        $message = Core_rbp::flashHTML('danger', 'Aucun sponsor trouvé');
    }

    if( $message == "" ) {
        $sponsor['logo'] = Sponsor::URL_LOGO . $sponsor['logo'];
    }
}

if ($message != "") {
    $_SESSION['flash'] = $message;
    header('location:/club');
    exit();
}

$id_domaine = (isset($sponsor['id_domaine']))? $sponsor['id_domaine'] : null;
$id_section = (isset($sponsor['id_section']))? $sponsor['id_section'] : null;

$domaines = $sponsorFactory->getDomaines();
$ArrDomIdToName = $sponsorFactory->idToName($domaines);

$formSponsor = Form::factoryForm($sponsor);
?>
<!DOCTYPE html>
<html>
    <?php include("includes/head.php"); ?>
    <body class="no-sectionBarre">
        <?php include("includes/header.php"); ?>
        <div class="contenu container">
            <h1><?= isset($_GET['id_sponsor'])? 'Modifier' : 'Ajouter'; ?> Sponsor</h1>
            <?php echo $message; ?>
            <form name="form-sponsor">
                <?php if (isset($_GET['id_sponsor'])) {echo '<input type="hidden" name="id_sponsor" value="'.htmlspecialchars($_GET['id_sponsor']).'">' ;} elseif (isset($_POST['id_sponsor'])) {echo '<input type="hidden" name="id_sponsor" value="'.htmlspecialchars($_POST['id_sponsor']).'">' ;} ?>
                <h4 class="bg-primary h4-size row-pad"> Infos gérénales: </h4>
                <div class="row-flex">
                    <?= $formSponsor -> nom('nom', 'Nom', ['obliger' => 1, 'width' => 'demi'])?>
                    <?= $formSponsor -> select('id_domaine', 'Domaine', $ArrDomIdToName, ['obliger' => 1, 'width' => 'order', 'default' => $id_domaine]) ?>
                    <?= $formSponsor -> select('id_section', 'Section', Section::ID_TO_NAME, ['obliger' => 1, 'width' => 'order', 'default' => $id_section]) ?>
                </div>
                <div class="row-flex">
                    <?= $formSponsor -> numb_rue('numbRue_sponsor', 'N°')?>
                    <?= $formSponsor -> rue('rue_sponsor', 'Rue', ['width' => 'demi'])?>
                    <?= $formSponsor -> cp('cp_sponsor', 'Code postal')?>
                    <?= $formSponsor -> ville('ville_sponsor', 'Ville', ['width' => 'order'])?>
                </div>
                <div class="row-flex">
                    <?= $formSponsor -> tel('tel', 'N° de téléphone', ['width' => 'order'])?>
                    <?= $formSponsor -> mail('mail', 'Adresse mail', ['width' => 'order'])?>
                    <?= $formSponsor -> site('site', 'Site internet', ['width' => 'order'])?>
                </div>
                <h4 class="bg-primary h4-size row-pad"> Description et logo </h4>
                <div class="row-flex">
                    <?= $formSponsor -> text('description', 'Description du sponsor.', ['obliger' => 1, 'width' => 'order']); ?>
                    <?= $formSponsor -> fileImg('logo', 'Logo du sponsor', ['obliger' => isset($_GET['id_sponsor'])? 0 : 1, 'width' => 'order' ]); ?>
                </div>
                <input type="submit" name="valide" class="btn btn-default" data-verif="form-sponsor" value="<?= isset($_GET['id_sponsor'])? 'Modifier' : 'Ajouter'; ?>">
            </form>
            <?php include("includes/footer.php"); ?>
        </div>
        <?php include("includes/script.php"); ?>
    </body>
</html>

