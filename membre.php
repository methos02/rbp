<?php

use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Membres';

if($log['droit'] < Droit::RESP){
    $_SESSION['flash'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
    header('location:/accueil');
    exit();
}

$message = "";
$adherentFactory = Adherent::factory();

if (!empty($_POST)) {
    if (!isset($_POST['id_membre']) || !is_numeric($_POST['id_membre'])) {
        $message = Core_rbp::flashHTML('danger', "L'id de l'adhérent est invalide");
    }

    if ($message == "" && (!isset($_POST['droit']) || !is_numeric($_POST['droit']))) {
        $message = Core_rbp::flashHTML('danger', "Droit d'accès invalide.");
    }

    if ($message == "" && $_POST['droit'] == Droit::USER) {
        $message = Core_rbp::flashHTML('danger', "L'utilisateur introduit ne peut pas être un utilisateur.");
    }

    if($message == "" && !isset(Droit::DROITS[$_POST['droit']])) {
        $message = Core_rbp::flashHTML('danger', "Droit invalide.");
    }

    if ($message == "" && !isset($_POST['id_sections'])) {
        $message = Core_rbp::flashHTML('danger', "Section introuvable.");
    }

    if($message == "" && !empty($_POST['id_sections'])) {
        foreach ($_POST['id_sections'] as $id_section) {
            if(!isset(Section::ID_TO_NAME[$id_section])) {
                $message = Core_rbp::flashHTML('danger', "Section invalide.");
                break;
            }
        }
    }

    //Vérification des sections en fonction des droits
    if($message == "" && empty($_POST['id_sections']) && in_array($_POST['droit'], [Droit::REDAC, Droit::RESP])) {
        $message = Core_rbp::flashHTML('danger', "Vous devez préciser la section.");
    }

    if($message == "") {

        //récupération des sections en string
        $section = "";
        if(in_array($_POST['droit'], [Droit::USER, Droit::ADMIN])) {
            $section = 0;
        } else {
            foreach ($_POST['id_sections'] as $id_section) {
                $section .= $id_section;
            }
        }

        $update = $adherentFactory->updateMembreDroits($_POST['id_membre'], $_POST['droit'], $section);

        if($update == 1) {
            $_SESSION['flash'] = Core_rbp::flash('success', "Le membre a été ajouté.");
            header('location:/membre');
            exit;
        } else {
            $message = Core_rbp::flashHTML('danger', "Aucune modification apportée.");
        }
    }
}

$membres = $adherentFactory->getMembres();
$membreForm = Form::factoryForm($_POST);
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body class="contenu no-sectionBarre">
		<div id="bloc_page">
			<?php include("includes/header.php"); ?>
			<section class="container-fluid">
                <h4 class="bg-primary h4-size row-pad"> Gestion des droits d'accès </h4>
                <?php echo $message ?>
                <div class="form-membre">
                    <table class="table-membre">
                        <thead>
                        <tr>
                            <th class="th-nom"> Nom </th>
                            <th class="th-nom"> Prénom </th>
                            <th> Droit </th>
                            <th class="th-checkbox"> Natation </th>
                            <th class="th-checkbox"> Water-polo </th>
                            <th class="th-checkbox"> Plongeon </th>
                            <th class="th-checkbox"> Comité </th>
                        </tr>
                        </thead>
                        <?php foreach($membres as $key => $membre): ?>
                            <tr data-id_membre="<?= $membre['id_membre'] ?>">
                                <td><?=  $membre['nom'] ?></td>
                                <td><?=  $membre['prenom'] ?></td>
                                <td>
                                    <select title="droit" name="droit" class="form-control">
                                        <?= Form::factoryForm()->defineOptions(Droit::RESP_ID_TO_DROIT, ['default' => $membre['droit']]) ?>
                                    </select>
                                </td>
                                <?php foreach (Section::GET_SECTIONS as $section ): ?>
                                    <td class="text-center"><input type="checkbox" title="<?= $section['id'] ?>" name="<?= $section['id'] ?>" <?= stripos($membre['section'], strval($section['id'])) !== FALSE ? 'checked="checked" ':''; ?> <?= $membre['droit'] == Droit::USER || $membre['droit'] == Droit::ADMIN  ? 'disabled="disabled" ':'' ?>></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <form name="form-membre" method="post" action="/membre">
                        <div class="row-flex">
                            <div class="span-submit"><input type="submit" name="valide" class="btn btn-default" value="Ajouter" data-verif="form-membre"></div>
                            <?= $membreForm->datalist('membre', 'Nom et prénom', '', ['obliger' => 1])?>
                            <?= $membreForm->select('droit', 'Droit', Droit::RESP_ID_TO_DROIT)?>
                            <?php foreach (Section::GET_SECTIONS as $section ) : ?>
                                <?= $membreForm ->checkbox('id_sections[]', $section['id'], ['disabled' => !isset($_POST['section']), 'checked' => isset($_POST['section']) && in_array($section['id'], $_POST['section'])]) ?>
                            <?php endforeach; ?>
                        </div>
                    </form>
                </div>
			</section>
			<?php include("includes/footer.php"); ?>
		</div>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
