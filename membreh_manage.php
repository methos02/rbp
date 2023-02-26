<?php include __DIR__.'/includes/init.php';
$factoryClub = Club::factory();
$membreh = "";
$message = "";

if( isset($_GET['id_membreh'])) {
    if(!is_numeric($_GET['id_membreh'])) {
        $message = "L'id est invalide";
    }

    if($message == "") {
        $membreh = $factoryClub->getMembreH($_GET['id_membreh']);

        if(empty($membreh)) {
            $message = "Aucun membre ne correspond à l'id renseignée.";
        }
    }

    if(!empty($membreh)) {
        $membreh['photo'] = Club::URL_PORTRAIT . $membreh['photo'];
    }

    if($message != "") {
        $_SESSION['flash'] = Core_rbp::flash("danger", $message);
        header('location:/club');
        exit;
    }
}

$portrait = (is_array($membreh))? $membreh['photo'] : 'inconnu.jpg';
$id_civilite = (is_array($membreh))? $membreh['id_civilite']: null;

$formMembreh = Form::factoryForm($membreh);
?>
<!DOCTYPE html>
<html>
<?php include("includes/head.php"); ?>
<body class="no-sectionBarre">
    <?php include("includes/header.php"); ?>
    <div class="contenu container">
        <h1><?= is_array($membreh)? 'Modifier' : 'Ajouter'; ?> Membre d'honneur </h1>
        <?php echo $message; ?>
        <form name="form-membreh" class="form-membreh">
            <?= is_array($membreh)?'<input type="hidden" name="id_membreh" value="'.$membreh['id_membreH'].'"">': '' ?>
            <div class="row-flex">
                <div class="flex">
                    <div class="row-flex">
                        <?= $formMembreh -> nom('nom', 'Nom', ['obliger' => 1, 'width' => 'order'])?>
                        <?= $formMembreh -> nom('prenom', 'Prénom', ['obliger' => 1, 'width' => 'order', 'message' => 'prenom']) ?>
                        <?= $formMembreh -> select('id_civilite', 'Civilité', Database::CIV_ID_TO_NAME, ['obliger' => 1, 'null' => true]) ?>
                    </div>
                    <div class="row-flex">
                        <?= $formMembreh -> date('birth', 'Date de naissance', ['type' => 'passe'])?>
                        <?= $formMembreh -> date('death', 'Date de décès', ['type' => 'passe'])?>
                    </div>
                    <div class="row-flex div-bio">
                        <h4> Biographie </h4>
                        <?= $formMembreh -> text('bio', 'Biographie', ['obliger' => 1]) ?>
                    </div>
                </div>
                <?= $formMembreh -> fileImg('photo', 'Choisissez une photo', ['option' => 'photo', 'defaut' => Club::URL_PORTRAIT . Club::DEFAUT_PHOTO])?>
            </div>
            <button type="submit" class="btn btn-primary submit-compact margin-top" name="submit" data-verif="form-membreh"> Enregistrer </button>
        </form>
    </div>
    <?php include("includes/footer.php"); ?>
    <?php include("includes/script.php"); ?>
    <script type="text/javascript">
        CKEDITOR.replace( 'bio');
    </script>
</body>
</html>