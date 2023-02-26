<?php include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Adhérent manage';

if($log['droit'] < Droit::RESP){
	$_SESSION['flash'] = Core_rbp::flash('danger',"Vous n'avez pas les droits pour accéder à cette page.");
	header('location:accueil.html');
	exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
	<?php include("includes/head.php"); ?>
	<body>
        <?php include("includes/header.php"); ?>
        <div class="navbar navbar-default navbar-secondaire navbar-fixed-top" style="z-index: 500">
            <?php include ('includes/header/adherentNavbar.php') ?>
        </div>
        <div class="contenu container-fluid">
            <div class="col-md-2">
                <ul class="ul-adherent" <?php echo isset($_GET['id_ads']) && is_numeric($_GET['id_ads'])? 'data-id_ads="'.$_GET['id_ads'].'"' : ''; ?>>
                    <li><a href="adherent" data-verif="forms_adherent"> Générale </a></li>
                    <li><a href="administratif" data-verif="forms_adherent"> Coordonées </a></li>
                    <li><a href="saison" data-verif="forms_adherent"> Saison </a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <h2 class="h-section">Ajouter un adhérent </h2>
                <?php include('includes/form/adherent_form.php') ?>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
		<?php include("includes/script.php"); ?>
	</body>
</html>	