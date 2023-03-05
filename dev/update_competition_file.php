<?php
use App\Core\Connection;

include __DIR__.'/../includes/init.php';

$bdd = Connection::getInstance();

$competitions = $bdd->req('SELECT com_id, com_liste, com_resultat, com_programme FROM t_competition')->fetchAll(PDO::FETCH_ASSOC);

foreach ($competitions as $competition) {
    $liste = (!empty($competition['com_liste']))? explode("/", $competition['com_liste'])[1] : null;
    $programme = (!empty($competition['com_programme']))? explode("/", $competition['com_programme'])[1] : null;
    $resultat = (!empty($competition['com_resultat']))? explode("/", $competition['com_resultat'])[1] : null;

    $bdd -> req('UPDATE t_competition SET com_programme = :programme, com_liste = :liste, com_resultat = :resultat WHERE com_id=:id_competition',['programme' => $programme, 'liste' => $liste, 'resultat' => $resultat, 'id_competition' => $competition['com_id']]);
}
