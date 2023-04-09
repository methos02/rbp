<?php include __DIR__.'/../includes/init.php';
$piscineFactory = Piscine::factory();
$matcheFactory = Match::factory();
$utilsFactory = Utils::factory();
$sectionFactory = Section::factory();
$mailFactory = Mail::factory();

ini_set('display_errors', -1);
ini_set('pcre.backtrack_limit', '999999999999');

if(!isset($_GET['cle']) || !in_array($_GET['cle'], Match::CLE_CRON)) {
    exit();
}

$calendrier = new Calendrier();

$urlSource = 'https://www.waterpolo-online.com/clubfr/?ClubId=WW0000000000270';
$exec = Core_rbp::prepareCurl($urlSource);
$message = '';
$matchsArray = [];
$piscinesMissing = '';

if($_GET['cle'] == Match::CLE_CRON['admin']) {
    $calendrier->updateSendMail(Calendrier::SEND_MAIL_UNABLE);
}

if(!$exec) {
    $message = 'Problème de cURL';
}

if ($message == "") {
    //récupération de toutes les piscines avec un nom wpo
    $piscines = $piscineFactory->getPiscinesWithWpoName();
    $arrayNameWPO = $piscineFactory->orderAssociateNameWpo($piscines);

    //Récupération des catégorie
    $categories = $sectionFactory->getCategories();
    $arrayNameIdCat = $sectionFactory->orderCatIdNameWP($categories);

    $id_saison = Saison::factory()->saisonActive(false);

    //Analyse des données récupéré en cURL
    $exec = preg_replace("/\r|\n/", "", $exec);
    $regex = '/<li id="rcorners_wedstrijden" class="accordion-item is-active" data-accordion-item>(.+?)<\/li>/s';
    preg_match_all($regex, $exec, $matchsLi);

    foreach ($matchsLi[1] as $key => $li) {
        $regex = '/ad>(.+?)<the/';
        preg_match_all($regex, $li, $matchJournees);

        foreach ($matchJournees[1] as $journee) {
            $message_match = '';
            //date
            $regexDate = $key == 0 ?"/<th class='text-left' style='width: 100px;' colspan='2'>(.*?)<\/th>/s" : "/<th class='text-left' style='width: 100px;'>(.*?)<\/th>/s";
            preg_match($regexDate, $journee, $matchDate);

            $matchsArray[$matchDate[1]] = [];
            $regexMatch = "/<tr class='text-center'>(.*?)<\/tr>/s";
            preg_match_all($regexMatch, $journee, $matchsFound);

            foreach ($matchsFound[1] as $matchFound) {
                $regexInfos = "/<td>(.*?)<\/td>/s";
                preg_match_all($regexInfos, $matchFound, $match);//0=>club_in, 1=>link_score, 2=>club_out, 3=> categorie

                if (trim($match[1][3]) == 'U 21') {continue;}

                //categorie
                $id_categorie = (strpos($match[1][3], 'SH II') !== false || strpos($match[1][3], 'Beker') !== false)? 'SH II': explode(' ', trim($match[1][3]))[0];
                $id_categorie = isset($arrayNameIdCat[$id_categorie])? $arrayNameIdCat[$id_categorie] : null;

                $coupe = strpos($match[1][3], 'Beker') !== false ? 1 : 0;

                //heure
                $regexHeure = "/<td >(.*?)<\/td>/s";
                preg_match($regexHeure, $matchFound, $heure);

                //ne pas tenir compte des matchs qui sont en cours
                if($heure[1] == "LIVE"){continue;}

                //id
                $regexId = "/MatchId=WW(.*?)&Report=/s";
                preg_match($regexId, $match[1][1], $id_match);

                //score
                $regexScore = "/'>(.*?)<\/a>/s";
                preg_match($regexScore, $match[1][1], $score);
                $score = (trim($score[1]) != '0 - 0')? trim($score[1]) : "";

                //récupération de la page de match
                $ficheMatch = Core_rbp::prepareCurl($matcheFactory->getUrlMacthWpo($id_match[1]));

                $regexContainer = "/<section class=\"container\">(.*?)<\/section>/s";
                preg_match($regexContainer, $ficheMatch, $container);

                $regexInfos = "/<small>(.*?)<\/small>/s";
                preg_match($regexInfos, $container[1], $infos);
                $infos = explode('•', $infos[1]); //2=>numéro de match 3=>adresse piscine, ville 4=> arbitre,

                //numéro de match
                $numb = rtrim(trim($infos[2]));
                //Nom de la piscine
                $nom_piscine = preg_replace("/\r|\n|\s/", "", $infos[3]);
                $id_piscine = (isset($arrayNameWPO[$nom_piscine]))? $arrayNameWPO[$nom_piscine] : null;

                //nom arbitre
                $arbitre = trim(rtrim(explode(':', $infos[4])[1]));

                if(strlen($arbitre) > 30) {
                    $arbitre = explode(',', $arbitre);
                    $arbitre = rtrim(trim($arbitre[0])) . ' - ' . rtrim(trim($arbitre[1]));
                }

                if(strlen($arbitre) > 0 && $arbitre[strlen($arbitre) - 1] == ',') {
                    $arbitre = substr($arbitre, 0, -1);
                }

                if($id_piscine == null) { $piscinesMissing .= $nom_piscine .' - ' . $match[1][0] . '<br>';}

                //Séparation des noms
                $nom_split = explode(' ', trim($match[1][0]));

                if($nom_split[1] == 'Louvière' || $nom_split[1] == 'Aqua') {
                    $nom_split[0] = $nom_split[0] . ' ' . $nom_split[1];
                    $nom_split[1] = $nom_split[2];
                }

                if($nom_split[0] == 'Aalst') {
                    $nom_split[1] = $nom_split[3];
                }

                $club_in = $nom_split[0];
                $initiale_in = $nom_split[1];

                $nom_split = explode(' ', trim($match[1][2]));

                if($nom_split[1] == 'Louvière' || $nom_split[1] == 'Aqua') {
                    $nom_split[0] = $nom_split[0] . ' ' . $nom_split[1];
                    $nom_split[1] = $nom_split[2];
                }

                if($nom_split[0] == 'Aalst') {
                    $nom_split[1] = $nom_split[3];
                }

                $club_out = $nom_split[0];
                $initiale_out = $nom_split[1];

                //Vérification des données trouvées
                $date = DateTime::createFromFormat('d-m-Y H:i', $matchDate[1] . ' ' . $heure[1]);
                if(!is_object($date)) {
                    $message_match = $id_match[1] . " - la date du match est invalide : " . htmlspecialchars($matchDate[1] . ' ' . $heure[1]) . " <br>";
                }

                if(!is_numeric($id_match[1])) {
                    $message_match .= "L'id du match est invalide - date :" . htmlspecialchars($matchDate[1]) . " <br>";
                }

                if(!is_numeric($numb)) {
                    $message_match .= $id_match[1] . " - le numéro du match est invalide :" . htmlspecialchars($numb) . " <br>";
                }

                if(!$utilsFactory->checkNom($club_in) || empty($club_in)) {
                    $message_match .= $id_match[1] . " - le nom du club in est invalide :" . htmlspecialchars($club_in) . htmlspecialchars($initiale_in) . " <br>";
                }

                if(!$utilsFactory->checkNom($initiale_in) || empty($initiale_in)) {
                    $message_match .= $id_match[1] . " - les initiales du club in sont invalide :" . htmlspecialchars($initiale_in) . htmlspecialchars($initiale_in) .  " <br>";
                }

                if(!$utilsFactory->checkNom($club_out) || empty($club_out)) {
                    $message_match .= $id_match[1] . " - le nom du club out est invalide :" . htmlspecialchars($club_out) . htmlspecialchars($initiale_out) .  " <br>";
                }

                if(!$utilsFactory->checkNom($initiale_out) || empty($initiale_out)) {
                    $message_match .= $id_match[1] . " - les initiales du club out sont invalide :" . htmlspecialchars($initiale_out) . htmlspecialchars($initiale_out) .  " <br>";
                }

                $score_verif = explode(' - ', $score);
                if($score != '' && (!is_numeric($score_verif[0]) || !is_numeric($score_verif[1]))) {
                    $message_match .= $id_match[1] . " - le score est invalide :" . htmlspecialchars($score) . " <br>";
                }

                $arbitre_verif = explode('-', $arbitre);
                if($arbitre_verif != "" && !$utilsFactory->checkNom($arbitre_verif[0])) {
                    $message_match .= $id_match[1] . " - le nom de l'arbitre principale est invalide :" . htmlspecialchars($arbitre_verif[0]) . " <br>";
                }

                if($arbitre_verif != "" && isset($arbitre_verif[1]) && !$utilsFactory->checkNom($arbitre_verif[1])) {
                    $message_match .= $id_match[1] . " - le nom de l'arbitre secondaire est invalide :" . htmlspecialchars($arbitre_verif[1]) . " <br>";
                }

                if($id_categorie == null) {
                    $message_match .= $id_match[1] . " - la categorie est invalide :" . htmlspecialchars($match[1][3]) . " <br>";
                }

                if($message_match != "") {
                    $message .= $message_match;
                    continue;
                }

                $matcheFactory -> addUpdateMatch($id_match[1], $numb, $coupe, $club_in, $initiale_in, $club_out, $initiale_out, $score, $arbitre, $id_categorie, $id_piscine, $id_saison, $date->format('Y-m-d H:i'));
            }
        }
    }
}

if(!empty($message) || !empty($piscinesMissing) && $calendrier->getSendMail() === Calendrier::SEND_MAIL_UNABLE) {
    $piscinesMissing = !empty($piscinesMissing)? ' <br> <strong>Erreur Piscine : </strong> <br> ' . $piscinesMissing : "";
    $mailFactory->mailErreurScraperWP($message . $piscinesMissing);

    if($_GET['cle'] === Match::CLE_CRON['bot']) {
        $calendrier->updateSendMail(Calendrier::SEND_MAIL_DISABLE);
    }
}