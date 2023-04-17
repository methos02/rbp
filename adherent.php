<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - adherent';
$adherentFactory = Adherent::factory();
$saisonFactory = Saison::factory();
$Utils = Utils::factory();
$form = Form::factoryForm();
$message = "";

if($log['droit'] == Droit::USER){
	$_SESSION['flash'] = Core_rbp::flash('danger','Page inaccessible.','Vous devez être connecté pour accéder à cette page.');
	header('location:accueil.html');
	exit();
}

if(!empty($_POST)) {
    if (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison'])) {
        $message = "L'id de la saison est invalide.";
    }

    if ($message == "" && (!isset($_POST['id_section']) || (!is_numeric($_POST['id_section']) && $_POST['id_section'] != 'all'))) {
        $message = "L'id de la section est invalide.";
    }

    if($message == "" && (!isset($_POST['statut']) || !in_array($_POST['statut'], Adherent::STATUT))) {
        $message = "Le statut est invalide.";
    }

    if($message == "" && (!isset($_POST['nom']) || (!empty($_POST['nom'] && !$Utils->checkNom($_POST['nom']))))) {
        $message = "Le nom de l'adhérent est invalide.";
    }

    if($message != "") {
        $_SESSION['flash'] = Core_rbp::flash('danger', $message);
    }
}

$id_saison = ($message == "" && isset($_POST['id_saison'])) ? $_POST['id_saison']: Saison::factory()->saisonActive(false) ;
$saisonActive = Saison::factory()->saisonActive(false);

$id_section = ($message == "" && isset($_POST['id_section'])) ? $_POST['id_section'] : null;
$statut = ($message == "" && isset($_POST['statut']))? $_POST['statut'] : null;
$nom = ($message == "" && isset($_POST['nom']))? $_POST['nom'] : null;

/*Définition des select*/
$saisons = $adherentFactory->getSaisonByAdherent();
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);
$id_adherents = $adherentFactory -> getAdherentsBySaison($id_saison, $id_section);

$adherents = $adherentFactory -> getAdherentSaison($id_adherents, ['multi' => true]);
$adherents = $adherentFactory->setsParams($adherents);
?>
<!DOCTYPE html>
<html lang="fr">
	<?php include("includes/head.php"); ?>
	<body class="body-flex">
        <?php include("includes/header.php"); ?>
        <div class="navbar navbar-default navbar-secondaire navbar-fixed-top">
            <?php include ('includes/header/adherentNavbar.php') ?>
            <form class="navbar-form navbar-right" data-div="barre-adherent">
                <?= $form->select('id_saison', 'Saison :', $arrSaiIdToSaison, ['verif' => 0, 'default' => $id_saison])?>
                <?= $form->select('id_section', 'Section :', ['all' => 'Toutes'] + Section::ID_TO_NAME, ['verif' => 0, 'default' => 'all'])?>
                <?= $form->select('statut', 'Statut :', Adherent::STATUT, ['verif' => 0]);?>
                <?= $form->datalist('adherent_name', "Nom de l'adhérent","", ['verif' => 0, 'reset' => true]) ?>
            </form>
        </div>
        <div class="container">
            <h2> Saison <?php echo Saison::factory() -> getSaisonLabel($id_saison) ?></h2>
            <div data-div="adherents">
                <?php if(!empty($adherents)) : ?>
                    <?php include ('includes/table/adherentsTable.php') ?>
                <?php endif;?>
                <?php if(empty($adherents)) : ?>
                    <?= Core_rbp::emptyResult('Aucun adhérent ne répond aux critères introduits.') ?>
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
