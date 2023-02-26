<?php include __DIR__.'/../includes/init.php';
$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$result['message'] = "";

if(!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison'])) {
    $result['message'] = Core_rbp::flash('danger',"L'id de la saison est incorrecte.");
}

if($result['message'] == "" && (!isset($_POST['id_section']) || !is_numeric($_POST['id_section']))) {
    $result['message'] = Core_rbp::flash('danger',"L'id de la section est incorrecte.");
}

if($result['message'] == "") {
    $competitions = $competitionFactory -> getAllCompetition($_POST['id_section'], $_POST['id_saison']);
    $competitions = $competitionFactory->setsCalendrierParams($competitions, $log);

    $result['calendrier'] = Core_rbp::view('includes/table/competitionsTable', ['competitions' => $competitions, 'log' => $log, 'id_section' => $_POST['id_section']]);
}

echo json_encode($result);