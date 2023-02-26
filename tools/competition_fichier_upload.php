<?php include __DIR__ . '/../includes/init.php';
$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$Utils = Utils::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour ajouté des pdf à une compétition.");
}

if($result['message'] == "" && (!isset($_POST['nom']) || !in_array($_POST['nom'], ['liste', 'programme', 'resultat']))) {
    $result['message'] = Core_rbp::flash('danger', 'Le nom est invalide');
}

if($result['message'] == "" && (!isset($_FILES[$_POST['nom']]) || !$Utils -> checkFichier($_POST['nom'], Competition::FICHIER_EXT, Competition::FICHIER_EXT))){
    $result['message'] = Core_rbp::flash('danger', 'Le fichier est invalide.', $Utils -> getErreur());
}

if($result['message'] == "" && (!isset($_POST['id_competition']) || !is_numeric($_POST['id_competition']))){
    $result['massage'] = Core_rbp::flash('danger', "L'ID de la competition est invalide");
}

if($result['message'] == "" && !file_exists('../'.Competition::FICHIER_REAL_PATH)) {
    $result['message'] = Core_rbp::flash('danger', 'Le dossier de destination est introuvable', 'Merci de concacter un administrateur.');
}

if($result['message'] == "") {
    $fichier = $competitionFactory -> move_file($_POST['nom'], Competition::FICHIER_REAL_PATH);
    $fichier = $competitionFactory -> updatePath($_POST['nom'], $fichier, $_POST['id_competition']);
    $result['message'] = Core_rbp::flash('success', 'Le fichier a bien été enregistré.');
    $result['link'] = '<a href="'.Competition::FICHIER_URL.$fichier.'" target="_blank" ><span class="glyphicon glyphicon-download "></span></a>';
}

echo json_encode($result);