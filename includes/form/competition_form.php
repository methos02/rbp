<?php

use App\Core\Form;

include_once __DIR__.'/../../includes/init.php';
$competitionFactory = Competition::factory();
$erreur = "";
$competition = "";

//Définition de l'ID section
if(!isset($_POST['id_section']) || !in_array($_POST['id_section'], [Section::NATATION['id'], Section::PLONGEON['id']])) {
    $erreur = "L'id de la section est invalide.";
}

if ($erreur == "" && strpos($_SERVER['HTTP_REFERER'], 'natation') === false && strpos($_SERVER['HTTP_REFERER'], 'plongeon') === false ) {
    $erreur = "La section est invalide.";
}

if($erreur == "" && isset($_POST['id_competition'])) {
    if(!is_numeric($_POST['id_competition'])) {
        $erreur = "L'id de la compétition est invalide.";
    }

    if($erreur == "") {
        $competition = $competitionFactory->getCompetition($_POST['id_competition']);

        //Mise au format des dates
        $competition['heure_rdv'] = $competition['date_in']. ' ' . $competition['heure'];

        //Mise au format de la dataliste
        $competition['piscine'] = $competition['ville_piscine'].' - '.$competition['nom_piscine'];
    }
}

if($erreur != "") {
    echo Core_rbp::flash('danger', $erreur);
    exit;
}

$optionDataliste = is_array($competition)? '<option value="'.$competition['ville_piscine'].' - '.$competition['nom_piscine'].'" data-id_piscine="'.$competition['id_piscine'].'">' :"";
$formCompetition = Form::factoryForm($competition);
?>
<h4 class="bg-primary h4-size"><?= (isset($competition['com_id'])? 'Modifier': 'Ajouter') ?> une compétition</h4>
<form name="form-competition" class="form-inline">
    <?php  echo (isset($competition['com_id'])? '<input type="hidden" name="id_competition" value="'. $competition['com_id'].'">': '') ?>
    <?php  echo '<input type="hidden" name="id_section" value="'.((strpos($_SERVER['HTTP_REFERER'], 'natation') !== false) ? Section::NATATION['id'] : Section::PLONGEON['id'] ).'">'; ?>
    <div class="row-flex">
        <?= $formCompetition -> titre ('nom_competition', 'Nom de la compétition', ['obliger' => 1, 'width' => 'demi']); ?>
        <label class="label-compact">
            <select name="statut" class="input-compact" data-type="select" data-obliger="1">
                <option value="-1">------</option>
                <option value="<?php echo Competition::S_PRESENT ?>" <?php if(isset($competition['statut']) && $competition['statut'] == Competition::S_PRESENT) {echo 'selected="selected"';} ?>>RBP Participe</option>
                <option value="<?php echo Competition::S_PAS_PRESENT ?>" <?php if(isset($competition['statut']) && $competition['statut'] == Competition::S_PAS_PRESENT) {echo 'selected="selected"';} ?>>RBP ne participe pas</option>
            </select>
            <span class="label-input"> Participation </span>
        </label>
    </div>
    <div class="row-flex">
        <?= $formCompetition -> date('in', 'Du', ['type' => 'scolaire', 'obliger' => 1])?>
        <?= $formCompetition -> date('out', 'Au', ['type' => 'scolaire']) ?>
        <?= $formCompetition -> heure('rdv', 'Heure du rendez-vous', ['obliger' => 1]) ?>
    </div>
    <div class="reference">
        <h4> Lieu de la compétition </h4>
        <span class="piscine_add">
            <input type="checkbox" id="piscine_add" name="add_piscine">
            <label for="piscine_add"> Ajouter une piscine </label>
        </span>
    </div>
    <div class="row-flex" data-partie="piscine">
        <?= $formCompetition -> datalist('piscine', 'Introduisez une ville', $optionDataliste, ['width' => 'demi', 'message' => 'piscine']) ?>
    </div>
    <div data-partie="piscine_add" style="display: none" ><?php include('piscine_form.php');?></div>
    <h4> Fichiers : </h4>
    <div class="row-flex text-center">
        <?php if ($_POST['id_section'] == Section::NATATION['id']) : ?>
            <?= $formCompetition->filePdf('liste', 'Liste des joueurs :', ['width' => 'tier']) ?>
            <?= $formCompetition->filePdf('programme', 'Programme :', ['width' => 'tier']) ?>
        <?php endif; ?>
        <?= $formCompetition->filePdf('resultat', 'Résulat :', ['width' => 'tier'])?>
    </div>
    <div class="row-pad text-center">
        <button class="btn btn-primary" id="btn-save" data-verif="form-competition"> Enregistrer </button>
        <button class="btn btn-default" data-close="competition_form"> Annuler </button>
    </div>
</form>
