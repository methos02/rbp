<?php include('../includes/init.php');
$newsFactory = News::factory();
$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$saisonFactory = Saison::factory();
$Utils = Utils::factory();
$result['message'] = '';

include ("verif/competition_verif.php");

if ($result['message'] == ''  && isset($_POST['id_competition']) && !is_numeric($_POST['id_competition'])) {
    $result['message'] = Core_rbp::flash('danger', "L'id compétition est invalide");
}

if($result['message'] == "" && is_numeric($_POST['id_piscine'])) {
    $piscine = $piscineFactory->getPiscineByID($_POST['id_piscine']);

    if(empty($piscine)) {
        $result['message'] = Core_rbp::flash('danger', "Aucune piscine ne correspond à l'id fournie.");
    }
}

if($result['message'] == ""  ) {
    $competition = $competitionFactory->getCompetition($_POST['id_competition']);

    if(empty($competition)) {
        $result['message'] = Core_rbp::flash('danger',"Aucune compétition ne correspond à l'id renseignée.");
    }
}

if($result['message'] == "" && isset($_POST['add_piscine'])) {
    $noAjax = true;
    include( __DIR__ . '/piscine_add.php');
}

if ($result['message'] == "" && isset($date_in, $date_out)) {
    $id_saison = Saison::factory()->saisonActive(false);
    $id_piscine = (isset($id_piscine))? $id_piscine: $_POST['id_piscine'];

    $heure = $_POST['heure_rdv'].':'.$_POST['minute_rdv'];
    $date_out = is_object($date_out) && method_exists($date_out, 'format')? $date_out->format('Y-m-d') : null ;
    $date_in = is_object($date_in) && method_exists($date_in, 'format') ? $date_in->format('Y-m-d') : null;

    $programmeName = $competitionFactory -> move_file('programme', Competition::FICHIER_REAL_PATH, $competition['programme']);
    $listeName = $competitionFactory -> move_file('liste', Competition::FICHIER_REAL_PATH, $competition['liste']);
    $resultatName = $competitionFactory -> move_file('resultat', Competition::FICHIER_REAL_PATH, $competition['resultat']);

    $competitionFactory -> updateCompetition($_POST['nom_competition'], $_POST['statut'], $id_saison, $date_in, $date_out, $heure, $programmeName, $listeName, $resultatName, $id_piscine, $_POST['id_competition']);

    $competitions = $competitionFactory -> getAllCompetition($_POST['id_section'], $id_saison);
    $competitions = $competitionFactory->setsCalendrierParams($competitions, $log);
    $result['competitions'] = Core_rbp::view('includes/table/competitionsTable', ['id_section' => $_POST['id_section'], 'competitions' => $competitions, 'log' => $log]);

    $result['message'] = Core_rbp::flash('success','La compétition a bien été modifié.');
    $result['success'] = 1;
}

echo json_encode($result);