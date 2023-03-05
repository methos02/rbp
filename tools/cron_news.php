<?php include __DIR__ . '/../includes/init.php';
$newsFactory = News::factory();
$mailFactory = Mail::factory();
$competitionFactory = Competition::factory();
$matchFactory = MatchM::factory();

if(!isset($_GET['cle']) || $_GET['cle'] != News::CLE_CRON) {
    exit();
}

$competitions = $competitionFactory->getNextWeekCompetitions();
$matchs = $matchFactory->getNextWeekMatchs();
$events = array_merge($competitions, $matchs);

if(empty($events)) {
    exit();
}

$news = '';
foreach (Section::GET_SECTIONS_SPORTIVE as $id_section => $section) {
    if(array_search($id_section, array_column($events, 'id_section')) === false) {continue;}

    $news .= '<strong>'.$section.'</strong>';

    $li_event = '';
    foreach ($events as $event) {
        if($event['id_section'] == Section::WATERPOLO['id'] && $event['id_section'] == $id_section) {
            //Récupération de la date
            $date = new DateTime($event['date']);

            //récupération du club adverse
            $club_adverse = (strpos($event['initiale_in'], 'RBP') === false )? $event['initiale_in']. ' ' .$event['club_in'] : $event['initiale_out']. ' ' .$event['club_out'] ;

            $li_event.= '<li>'
                .           'L\'équipe '.$event['categorie'].' contre '. $club_adverse .' le '. $date->format('d/m/Y H:i') .' à la piscine de '. $event['ville'].'.'
                .       '</li>';
        } elseif($event['id_section'] == $id_section) {
            //récumépration des dates
            $date_in = new DateTime($event['date_in']);
            $date_out = ($event['date_out'] !== null)? new DateTime($event['date_out']): false;
            $date = ($date_out != false)? 'du '.$date_in->format('d/m/Y').' '.$event['heure']. ' au '. $date_out->format('d/m/Y'): 'le '.$date_in->format('d/m/Y').' '.$event['heure'] ;

            $li_event.= '<li>'
                .           'La compétition "'. $event['nom_competition'].'" '. $date .' à la piscine de '.$event['ville_piscine']
                .       '</li>';
        }
    }

    $news .= '<ul>'.$li_event.'</ul>';
}

$news =  '<p>Voici la liste des évènements auxquels participe le RBP ce week-end.</p>'
    .    $news
    .   '<p>Vous trouverez plus d\'informations sur la page des sections à la rubrique compétition</p>'
    .   '<p>Nous vous attendons nombreux pour nous encourager</p>'
    .   '<p> Les sportifs du RBP</p>';

$titre = 'Evênements du week-end';
$newsFactory->addNews($titre, $news, News::IMG_DEFAULT_COMITE,Section::COMITE['id'], 'Royal Brussels Poseidon');
$mailFactory ->sendMailNews($titre);
