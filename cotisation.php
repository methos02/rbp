<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Cotisation';
$adherentFactory = Adherent::factory();
$form = Form::factoryForm();
$message = "";

if($log['droit'] == Droit::USER){
	$_SESSION['flash'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
	header('location:/accueil');
	exit();
}

/* Récupération du tableau*/
if (isset($_POST['id_section']) && !is_numeric($_POST['id_section']) && $_POST['id_section'] != 'all') {
    $message = Core_rbp::flash('danger',"L'id section est invalide.");
}

if ($message == "" && isset($_POST['id_section']) && is_numeric($_POST) && !in_array($_POST['id_section'], Section::ID_TO_NAME[$_POST['id_section']])) {
    $message = Core_rbp::flash('danger',"Aucune section ne correspond à l'id renseigné.");
}

$id_section = ($message != "" || !isset($_POST['id_section']))? 'all' : $_POST['id_section'];
$section = $adherentFactory->defineWhereSection($id_section);
$id_ads = $adherentFactory->getIdSaisonByParams(Saison::factory()->saisonActive(false), $section, Adherent::WHERE_STATUT['C']);

if(!empty($id_ads)) {
    $adherents = $adherentFactory->getAdherentSaison($id_ads, ['multi' => true]);
}
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body class="body-flex">
		<?php include("includes/header.php"); ?>
		<div class="navbar navbar-default navbar-secondaire navbar-fixed-top" style="z-index: 500">
			<div class="container-fluid">
				<form class="navbar-form navbar-right" method="post">
					<div class="form-group ">
						<label for="id_section">Section souhaité:</label>
						<select name="id_section" id="id_section" class="form-control">
							<?= $form->defineOptions(['all' => 'Toutes'] + Section::GET_SECTIONS_SPORTIVE, ['default' => $id_section])?>
						</select>
						<input type="submit" class="btn btn-default btn-news" value="Valider"/>
					</div>
				</form>
			</div>
		</div>
		<div class="container">
			<h2>Cotisation non payée</h2>
            <?php if(!empty($adherents)) : ?>
                <form name="gestion_cotisations">
                    <table class="table-cotisations table table-bordered table-condensed">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th class="td-id_montant">Montant de la cotisation</th>
                            <th class="td-montant">Montant payé</th>
                        </tr>
                        <?php foreach ($adherents as $adherent): ?>
                            <tr>
                                <td><?= $adherent['nom'] ?></td>
                                <td><?= $adherent['prenom'] ?></td>
                                <td>
                                    <label>
                                        <select name="<?= $adherent['id_ads'] ?>[id_cotisation]" class="form-control">
                                            <?= $form->defineOptions(Database::COT_ID_TO_LABEL, ['default' => $adherent['id_cotisation']])?>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label class="input-group">
                                        <input type="text" name="<?= $adherent['id_ads'] ?>[montant]" maxlength="3" value="<?= $adherent['montant'] ?>" class="form-control" <?= isset(Database::ARRAY_NO_COT[$adherent['id_cotisation']])? 'disabled="disabled"':""?> >
                                        <span class="input-group-addon"> € </span>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <input type="submit" value="Envoyer" name="valide"/>
                </form>
            <?php endif ; ?>
            <?php if(empty($adherents)) : ?>
                <div class="text-center empty-result"> Tous les adhérents sont en ordre dans <?= $id_section == 'all'? 'le club' : 'cette section' ?>. </div>
            <?php endif; ?>
		</div>
		<?php include("includes/footer.php"); ?>
		<?php include("includes/script.php"); ?>
	</body>
</html>	
