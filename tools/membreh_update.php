<?php include __DIR__.'/../includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Membre d\'honneur manage';
$clubFactory = Club::factory();
$Utils = Utils::factory();
$result['message'] = '';

if(!isset($_POST['id_membreh']) || !is_numeric($_POST['id_membreh'])){
    $message = Core_rbp::flashHTML('danger',"L'id du membre est incorrect");
}

if($result['message'] == "") {
    include ('verif/membreh_verif.php');
}

if($result['message'] == "") {
    $date_birth = (!empty($_POST['jour_birth']))? new DateTime($_POST['annee_birth'].'-'.$_POST['mois_birth'].'-'.$_POST['jour_birth']) : null;
    $date_death = (!empty($_POST['jour_death']))? new DateTime($_POST['annee_death'].'-'.$_POST['mois_death'].'-'.$_POST['jour_death']) : null;

    if ($date_birth != null && $date_death != null && $date_death->getTimestamp() < $date_birth->getTimestamp()){
        $result['message'] = Core_rbp::flashHTML('danger','Incohérence entre la date de naissance et de décès.');
    }
}

if($result['message'] == "") {
    $membre = $clubFactory->getMembreH($_POST['id_membreh']);

    if(empty($membre)) {
        $result['message'] = Core_rbp::flash('danger',"Aucun membre ne correspond à l'id renseignée.");
    }

    if($result['message'] == "" && $membre['mem_supplogiq']) {
        $result['message'] = Core_rbp::flash('danger',"Ce membre a été supprimé.");
    }
}

if ($result['message'] == "") {
    $date_birth = (is_object($date_birth))? $date_birth->format('Y-m-d') : null;
    $date_death = (is_object($date_death))? $date_death->format('Y-m-d') : null;

    $photo = $clubFactory -> move_file('photo', Club::URL_REAL_PATH, $membre['photo']);
    $clubFactory -> updateMembreH($_POST['id_membreh'], $_POST['nom'], $_POST['prenom'], $_POST['id_civilite'], $date_birth, $date_death, $_POST['bio'], $photo);

    $result['message'] = Core_rbp::flash('success',"Le membre d'honneur a bien été modifié.");
}

echo json_encode($result);