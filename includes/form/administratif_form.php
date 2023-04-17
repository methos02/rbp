<?php use App\Core\Form;

include __DIR__.'/../init.php';
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
<form name="forms_adherent" action="adherent_admin_modif">
    <input type="hidden" name="id_ads" value="<?= $_POST['id_ads'] ?>">
    <h4 class="bg-primary h4-size"> Adresse </h4>
    <div class="row-flex">
        <div class="row-column order">
            <strong>Première Adresse</strong>
            <div class="row-flex">
                <?= $adherentForm->rue('rue_1', 'Rue', ['width' => 'order'])?>
                <?= $adherentForm->numb_rue('numbRue_1', 'N°')?>
            </div>
            <div class="row-flex">
                <?= $adherentForm->cp('cp_1', 'Code postal') ?>
                <?= $adherentForm->ville('ville_1', 'Ville', ['width' => 'order']) ?>
            </div>
        </div>
        <div class="row-column order">
            <strong>Seconde Adresse</strong>
            <div class="row-flex">
                <?= $adherentForm->rue('rue_2', 'Rue', ['width' => 'order'])?>
                <?= $adherentForm->numb_rue('numbRue_2', 'N°')?>
            </div>
            <div class="row-flex">
                <?= $adherentForm->cp('cp_2', 'Code postal') ?>
                <?= $adherentForm->ville('ville_2', 'Ville', ['width' => 'order']) ?>
            </div>
        </div>
    </div>
    <h4 class="bg-primary h4-size"> Numéro de Téléphone </h4>
    <div class="row-flex">
        <?= $adherentForm->tel('tel', 'Téléphone fixe', ['width' => 'order']) ?>
        <?= $adherentForm->tel('gsm', "GSM de l'adhérent", ['width' => 'order']) ?>
        <?= $adherentForm->tel('gsm_mere', 'GSM de la mère', ['width' => 'order']) ?>
        <?= $adherentForm->tel('gsm_pere', 'GSM du père', ['width' => 'order']) ?>
    </div>
    <h4 class="bg-primary h4-size"> Adresse Email </h4>
    <div class="row-flex">
        <?= $adherentForm->mail('mail', 'Adhérent', ['width' => 'order']) ?>
        <?= $adherentForm->mail('mail_mere', 'Mère', ['width' => 'order']) ?>
        <?= $adherentForm->mail('mail_pere', 'Père', ['width' => 'order']) ?>
    </div>
    <input type="submit" name="valide" class="btn btn-primary" value="Enregistrer" data-verif="forms_adherent">
</form>
