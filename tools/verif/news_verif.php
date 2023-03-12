<?php

use App\Models\News;

if($log['droit'] == Droit::USER){
    $result['message'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
}

if($result['message'] == '' && (!isset($_POST['news']) || empty($_POST['news']))){
    $result['message'] = Core_rbp::flash("danger","La news introduite est vide.");
}

if($result['message'] == '' && (!isset($_POST['titre']) || !$Utils -> checkTitre($_POST['titre']))){
    $result['message'] = Core_rbp::flash("danger","Le titre est incorrect.");
}

if($result['message'] == '' && (!isset($_POST['id_section']) || !isset(Section::ID_TO_NAME[$_POST['id_section']]))){
    $result['message'] = Core_rbp::flash("danger","L'id de la news est invalide.");
}

if ($result['message'] == '' && (!isset($_FILES['photo']) || ($_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE && !$Utils -> checkFichier('photo', News::EXT_NEWS, News::SIZE_NEWS)))){
    $result['message'] = Core_rbp::flash("danger","La photo est incorrect", $Utils -> getErreur());
}

if ($result['message'] == "" && !is_dir(__DIR__.'/../../'.News::PATH_IMG_REAL)) {
    $result['message'] = Core_rbp::flash('danger', "Le chemin pour enregistré les photos est invalide.");
}
