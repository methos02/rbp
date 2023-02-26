<?php include __DIR__.'/../includes/init.php';
$Utils = Utils::factory();
$adherentFactory = Adherent::factory();
$sectionFactoy = Section::factory();
$result['message'] = "";
$categories = [];

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier la fiches des adhérents.");
}

if( $result['message'] == "" && $Utils->checkEmptyForm($_POST)){
    $result['message'] = Core_rbp::flash('danger', "Vous devez introduire un adhérent pour changer d'onglet.");
}

if($result['message'] == "" && (isset($_POST['id_adherent']) && !is_numeric($_POST['id_adherent']))){
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est incorrect.");
}

if($result['message'] == "" && (!isset($_POST['nom']) || !$Utils->checkNom($_POST['nom']))) {
    $result['message'] = Core_rbp::flash('danger', "Le nom est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['prenom']) || !$Utils->checkNom($_POST['prenom']))) {
    $result['message'] = Core_rbp::flash('danger', "Le prenom est incorrect.");
}

if ($result['message'] == '' && (!isset($_POST['civilite']) || !$Utils->checkSelect($_POST['civilite']))) {
    $result['message'] = Core_rbp::flash('danger', "La civilité est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['nationalite']) || !$Utils->checkNom($_POST['nationalite']))) {
    $result['message'] = Core_rbp::flash('danger', "La nationalité est incorrect.");
}

if ($result['message'] == "" && (!isset($_POST['jour_birth'], $_POST['mois_birth'], $_POST['annee_birth']) || !$Utils->checkDate($_POST['jour_birth'],$_POST['mois_birth'], $_POST['annee_birth'], 'passe'))){
    $result['message'] = Core_rbp::flash('danger', 'Date naissance incorrecte.');
}

if ($result['message'] == "" && (!empty($_POST['jour_in']) || !empty($_POST['mois_in']) || !empty($_POST['annee_in'])) && !$Utils->checkDate($_POST['jour_in'],$_POST['mois_in'], $_POST['annee_in'], 'passe')){
    $result['message'] = Core_rbp::flash('danger', "Date d'entrée dans le club incorrecte.");
}

if ($result['message'] == "" && (!isset($_POST['section']) || $_POST['section'] == ['','','',''])) {
    $result['message'] = Core_rbp::flash('danger', "Vous devez compléter la section.");
}

if($result['message'] == "") {
    $array_id_cat = $sectionFactoy->getId_cats();
    $use_uniq_cat = $sectionFactoy->getUse_uniq_cat();

    //VERIFIVATION DE LA SECTION
    foreach ($_POST['section'] as $i => $id_section) {
        if($result['message'] != ""){break;}

        if($id_section == "") {
            unset($_POST['section'][$i]);
            continue;
        }

        if($result['message'] == "" && !is_numeric($id_section)){
            $result['message'] = Core_rbp::flash('danger', "Id section invalide.");
            break;
        }

        if($result['message'] == "" && !isset(Section::ID_TO_NAME[$id_section])){
            $result['message'] = Core_rbp::flash('danger', "Id section inconnu.");
            break;
        }

        if($result['message'] == "" && empty($_POST['fonction'][$id_section])) {
            $result['message'] = Core_rbp::flash('danger', "Vous devez compléter la fonction pour la section ".Section::ID_TO_NAME[$id_section].".");
            break;

        }

        if($result['message'] == "") {
            //VERIFICATION DE LA FONCTION
            foreach ($_POST['fonction'][$id_section] as $id_fonction) {
                if($result['message'] == "" && !is_numeric($id_fonction)){
                    $result['message'] = Core_rbp::flash('danger', "L'id de la fonction est invalide.");
                    break 2;
                }

                if($result['message'] == "" && !isset(Database::FON_ID_TO_NAME[$id_fonction])){
                    $result['message'] = Core_rbp::flash('danger', "L'id de la fonction est inconnue.");
                    break 2;
                }

                if($result['message'] == "" && empty($_POST['categorie'][$id_section][$id_fonction]) && ($id_section != Section::PLONGEON['id'] || ($id_section == Section::PLONGEON['id'] && $id_fonction == Database::F_RESPONSABLE))) {
                    $result['message'] = Core_rbp::flash('danger', "Vous devez compléter la catégorie pour la fonction " . Database::FON_ID_TO_NAME[$id_fonction] . " de la section " . Section::ID_TO_NAME[$id_section] .".");
                    break 2;

                } elseif($result['message'] == "" && ($id_section != Section::PLONGEON['id'] || ($id_section == Section::PLONGEON['id'] && $id_fonction == Database::F_RESPONSABLE))) {
                    //VERIFICATION DE LA CATEGORIE
                    foreach ($_POST['categorie'][$id_section][$id_fonction] as $id_categorie) {
                        if($result['message'] == "" && !is_numeric($id_categorie)){
                            $result['message'] = Core_rbp::flash('danger', "L'id de la catégorie est invalide.");
                            break 3;
                        }

                        if($result['message'] == "" && !in_array($id_categorie, $array_id_cat)){
                            $result['message'] = Core_rbp::flash('danger', "L'id de la catégorie est inconnue.");
                            break 3;
                        }

                        if($result['message'] == "" && in_array(array($id_section, $id_fonction, $id_categorie), $use_uniq_cat)){
                            $categorie = $sectionFactoy->getCategorie($id_categorie);
                            $result['message'] = Core_rbp::flash('danger', "La fonction ".$categorie['categorie']." section (".Section::ID_TO_NAME[$id_section].")déjà utilisée.");
                            break 3;
                        }

                        if($result['message'] == "") {
                            $categories[] = ['id_section' => $id_section, 'id_fonction' => $id_fonction, 'id_categorie' => $id_categorie];
                        }
                    }
                }
            }
        }
    }
}

if($result['message'] == "" && isset($_POST['cs'])){
    foreach ($_POST['cs'] as $id_section) {
        if($result['message'] == "" && !is_numeric($id_section)){
            $result['message'] = Core_rbp::flash('danger', "Id section pour le cs invalide.");
            break;
        }

        if($result['message'] == "" && !isset(Section::ID_TO_NAME[$id_section])){
            $result['message'] = Core_rbp::flash('danger', "Id section pour le cs inconnu.");
            break;
        }
    }
}

if($result['message'] == "" && isset($_POST['id_adherent'])) {
    $adherent = $adherentFactory->getAdherent($_POST['id_adherent']);

    if(empty($adherent)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent de correspond à l'id.");
    }
}

if($result['message'] == "" && !isset($_POST['id_adherent'])) {
    $adherent = $adherentFactory->getAdherentByNameBirth($_POST['nom'], $_POST['prenom'], $_POST['annee_birth'].'-'.$_POST['mois_birth'].'-'.$_POST['jour_birth']);

    if(!empty($adherent)) {
        $result['message'] = Core_rbp::flash('danger', "L'adhérent existe déjà.");
    }
}

if ($result['message'] == "") {
    if (isset($_POST['id_adherent'])) {
        $adherentFactory->updateAdherent($_POST['nom'], $_POST['prenom'], $_POST['annee_birth'].'-'.$_POST['mois_birth'].'-'.$_POST['jour_birth'], $_POST['civilite'], $_POST['nationalite'], $_POST['id_adherent']);
        $id_ads = $adherentFactory->getId_ads($_POST['id_adherent'], Saison::factory()->saisonActive(false));
    }

    if (!isset($_POST['id_adherent'])) {
        $result['id_adherent'] = $adherentFactory->addAdherent($_POST['nom'], $_POST['prenom'], $_POST['annee_birth'].'-'.$_POST['mois_birth'].'-'.$_POST['jour_birth'], $_POST['civilite'], $_POST['nationalite']);
        $id_ads = $adherentFactory->addAdherentSaison($result['id_adherent']);
    }

    $id_adherent = (isset($_POST['id_adherent'])) ? $_POST['id_adherent'] : $result['id_adherent'];

    $adherentFactory->suppAllCategories($id_ads);
    $adherentFactory->suppAllCss($id_adherent);

    $req = $adherentFactory->prepReqCategories($categories, $id_ads);
    $adherentFactory->addOrUpdateCategories($req);

    if(isset($_POST['cs'])){
        $req = $adherentFactory->prepReqCss($_POST['cs'], $_POST['id_adherent']);
        $adherentFactory->addOrUpdateCs($req);
    }

    $result['message'] = (isset($_POST['id_adherent']))? Core_rbp::flash('success', "L'adhérent a été modifié.") : Core_rbp::flash('success', "L'adhérent a été ajouté.");
    $result['success'] = 1;
}

echo json_encode($result);