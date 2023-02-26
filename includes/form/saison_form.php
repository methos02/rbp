<?php include __DIR__.'/../init.php';
$adherentFactory = Adherent::factory();
$message = "";

if(!isset($_POST['id_ads']) || !is_numeric($_POST['id_ads'])){
    $message =  "L'id de l'adhérent est incorrect.";
}

if ($message == "") {
    $adherent = $adherentFactory -> getAdherentSaison($_POST['id_ads']);

    if( empty($adherent)) {
        $message =  "Aucun adhérent ne correspond à l'id renseigné.";
    }
}

if ($message != ""){
    echo Core_rbp::flash('danger', $message);
    exit();
}

$adherentForm = Form::factoryForm($adherent);
?>
<form name="forms_adherent" action="adherent_saison_modif">
    <input type="hidden" name="id_ads" value="<?= $_POST['id_ads'] ?>">
    <h4 class="bg-primary h4-size">Information Licence </h4>
    <div class="row-flex">
        <?= $adherentForm->license('numb_licence', 'N° de licence', ['width' => 'order']) ?>
        <?= $adherentForm->select('id_licence','Type de licence', Database::L_ID_TO_LABEL, ['default' => $adherent['id_licence']]) ?>
        <?= $adherentForm->date('licence', 'Date de licence', ['type' => 'passe'])?>
        <?= $adherentForm->date('certif', 'Date du certificat', ['type' => 'saison'])?>
    </div>
    <h4 class="bg-primary h4-size"> Cotisation </h4>
    <div class="row-flex">
        <?= $adherentForm->select('id_cotisation', 'Montant', Database::COT_ID_TO_LABEL, ['default' => $adherent['id_cotisation']])?>
        <?= $adherentForm->numb('montant', 'Montant perçu', ['addon' => '€'])?>
        <?= $adherentForm->date('cotisation', 'Dernier versement', ['type' => 'saison']) ?>
    </div>
    <input type="submit" name="valide" class="btn btn-primary" value="Enregistrer" data-verif="forms_adherent">
</form>
