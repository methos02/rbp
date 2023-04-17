<?php use App\Core\Form;

include_once __DIR__.'/../init.php';
$adherentFactory = Adherent::factory();
$sectionFactoy = Section::factory();
$adherent = "";
$message = "";

if(isset($_GET['id_ads']) && !is_numeric($_GET['id_ads'])){
    $message =  "L'id de l'adhérent est incorrect.";
}

if ($message == "" && isset($_GET['id_ads'])) {
    $adherent = $adherentFactory -> getAdherentSaison($_GET['id_ads']);

    if( empty($adherent)) {
        $message =  "Aucun adhérent ne correspond à l'id renseigné.";
    }

    if($message == "") {
        $adherent['categories'] = $adherentFactory -> getAdherentCategories($_GET['id_ads']);
    }
}

if ($message != ""){
    echo Core_rbp::flash('danger', $message);
    exit();
}

$adherentForm = Form::factoryForm($adherent);

/* Création des div fonction */
$categories = Section::factory()->getCategories();
$liOpen = false;
$inputFonction = [];
$cs = [];
foreach (Section::GET_SECTIONS as $section) {
    $fonctions = ($section['id'] == Section::COMITE['id'])? Database::CA: Database::FONCTIONS;
    $inputSection = "";
    foreach ($fonctions as $fonction) {
        $liCategorie = '';
        $totalCheck = 0;
        foreach ($categories as $categorie) {
            if($categorie['id_section'] == $section['id'] && strpos($categorie['id_fonction'], strval($fonction['id'])) !== false) {
                $currentCategorie = ['id_section' => $section['id'],'id_fonction' =>  $fonction['id'], 'id_categorie' =>  $categorie['id_categorie'], 'categorie' => $categorie['categorie']];
                $checked = (isset($adherent['categories']) && in_array($currentCategorie, $adherent['categories'])?'checked="checked"':'');
                if($checked != "") {$totalCheck ++;}

                $liCategorie .='<li><label><input type="checkbox" name="categorie['.$section['id'].']['.$fonction['id'].'][]" value="'.$categorie['id_categorie'].'" '.$checked.'>'.$categorie['categorie'].'</label></li>';
            }
        }

        $ulCategorie = "";
        if(!empty($liCategorie)) {
            $intitule = $totalCheck < 2 ? ' catégorie' : ' catégories';
            $ulCategorie =  '<span class="reference form-control input-group-right">'
            .                   '<a href="" class="a-categorie dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="a-intitule"> '. $totalCheck . $intitule .' </span><span class="caret"></span></a>'
            .                   '<ul class="dropdown-menu ul-categorie">'.$liCategorie.'</ul>'
            .               '</span>';
        }

        $inputSection .=   '<div class="col-md-4 col-sm-6 margin-updown form-inline">'
            .                   '<div class="input-group">'
            .                       '<span class="input-group-addon color-'. $section['id'] .'"><input type="checkbox" name="fonction['.$section['id'].'][]" value="'.$fonction['id'].'" '.(isset($adherent['categories']) && array_search($section['id'], array_column($adherent['categories'], 'id_section')) !== false && array_search($fonction['id'], array_column($adherent['categories'], 'id_fonction')) !== false?'checked="checked"':'').'></span>'
            .                       '<label class="form-control label-fonction '.((!empty($liCategorie))?'input-group-left':'').'">'. $fonction['name'].'</label>'
            .                   '</div>'
            .                   $ulCategorie
            .               '</div>';

        $liOpen = ($liOpen == false && $totalCheck != 0)? $section['id'] : $liOpen;
    }


    if($section['id'] != Section::COMITE['id']) {
        $cs[$section['id']] =   '<div class="col-md-3 col-sm-6 margin-updown form-inline">'
            .       '<div class="input-group">'
            .           '<span class="input-group-addon color-'. $section['id'] .'"><input type="checkbox" name="cs[]" value="'.$section['id'].'"></span>'
            .           '<label class="form-control label-fonction"> Membre du CS </label>'
            .       '</div>'
            .    '</div>';
    }

    $inputFonction[$section['id']] = $inputSection;
}

$divFonction = "";
$liOpen = ($liOpen == false)? Section::NATATION['id']: $liOpen;
foreach (Section::GET_SECTIONS as $section) {
    $divFonction .= '<div class="row margin-updown" data-div="'.$section['id'].'" '.(($liOpen == $section['id'])?'':'style="display:none"').'>'
        .               '<input type="hidden" name="section[]" ' . (isset($adherent['categories']) && array_search($section['id'], array_column($adherent['categories'], 'id_section')) !== false ?'value="'.$section['id'].'"':'') .'>'
        .               $inputFonction[$section['id']]
        .               ($section['id'] !=Section::COMITE['id'] ? $cs[$section['id']] : '')
        .           '</div>';
}
?>
<form  name="forms_adherent" action="adherent_modif" >
    <?php if($adherent != "") { echo '<input type="hidden" name="id_adherent" value="' . $adherent['id_adherent'] .'">';} ?>
    <h4 class="bg-primary h4-size"> Informations générales </h4>
    <div class="row-flex">
        <?= $adherentForm->nom('nom', 'Nom', ['obliger' => 1, 'width' => 'order'])?>
        <?= $adherentForm->nom('prenom', 'Prénom', ['obliger' => 1, 'width' => 'order', 'message' => 'prenom']) ?>
        <?= $adherentForm->select('civilite', 'Civilité', Database::CIV_ID_TO_NAME, ['obliger' => 1])?>
    </div>
    <div class="row-flex">
        <?= $adherentForm->nom('nationalite', 'Nationalité', ['obliger' => 1, 'message' => 'nationalite'])?>
        <?= $adherentForm->date('birth', 'Date de naissance', ['obliger' => 1])?>
    </div>
    <div class="row padding-btns"><?php echo Section::getLinksSection($liOpen) ?></div>
    <?php echo $divFonction ?>
    <input type="submit" name="valide" class="btn btn-primary" value="Enregistrer" data-verif="forms_adherent">
</form>
