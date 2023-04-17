<?php use App\Core\Form;
use App\Models\News;

include('../includes/init.php');
$newsFactory = News::factory();
$competitionFactory = Competition::factory();
$piscineFactory = Piscine::factory();
$form = Form::factoryForm();
$saisonFactory = Saison::factory();
$Utils = Utils::factory();
$result['message'] = '';

include ("verif/competition_verif.php");

if($result['message'] == "" && isset($_POST['add_piscine'])) {
    $competition = true;
    include( __DIR__ . '/piscine_add.php');
}

if ($result['message'] == "" && isset($date_in, $date_out)) {
    $id_saison = Saison::factory()->saisonActive(false);
    $id_piscine = (isset($id_piscine))? $id_piscine: $_POST['id_piscine'];

    $heure = $_POST['heure_rdv'].':'.$_POST['minute_rdv'];
    $date_out = (is_object($date_out) && method_exists($date_out, 'format'))? $date_out->format('Y-m-d') : null ;
    $date_in = (is_object($date_in) && method_exists($date_in, 'format'))? $date_in->format('Y-m-d') : null ;

    $liste = $competitionFactory -> move_file('liste', Competition::FICHIER_REAL_PATH);
    $programme = $competitionFactory -> move_file('programme', Competition::FICHIER_REAL_PATH);
    $resultat = $competitionFactory -> move_file('resultat', Competition::FICHIER_REAL_PATH);

    $competitionFactory -> addCompetition($_POST['nom_competition'], $_POST['statut'], $id_saison, $date_in, $date_out, $heure, $id_piscine, $_POST['id_section'], $resultat, $liste, $programme);
    $result['message'] = Core_rbp::flash('success','La compétition a bien été ajouté.');
    $result['success'] = 1;

    /* Vérificaition que ce n'est pas la première compétition de la saison + renvoie de l'id de la saison */
    if(sizeof($competitionFactory->getAllCompetition($_POST['id_section'], $id_saison)) == 1) {
        $saisons = $saisonFactory->getSaisonsByCompetition($_POST['id_section']);
        $result['select'] = $form->defineOptions($saisons, ['default' => $id_saison, 'null' => 1]);
    }

    $competitions = $competitionFactory -> getAllCompetition($_POST['id_section'], $id_saison);
    $competitions = $competitionFactory->setsCalendrierParams($competitions, $log);
    $result['competitions'] = Core_rbp::view('includes/table/competitionsTable', ['id_section' => $_POST['id_section'], 'competitions' => $competitions, 'log' => $log]);
}

echo json_encode($result);
