<?php include __DIR__ . '/../includes/init.php';
$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$result['message'] = "";

if(!isset($_POST['id_competition']) || !is_numeric($_POST['id_competition'])) {
    $result['message'] = Core_rbp::flash('danger',"L'id de la compétition est invalide.");
}

if($result['message'] == "") {
    $competition = $competitionFactory -> getCompetition($_POST['id_competition']);

    if(empty($competition)) {
        $result['message'] = Core_rbp::flash('danger',"Aucune compétition trouvée.");
    }
}

if($result['message'] == "") {
    $competition = $competitionFactory -> setFicheParams($competition);
    $result['fiche'] = Core_rbp::view('includes/fiche/competitionFiche', compact('competition'));
}

echo json_encode($result);