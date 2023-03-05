<?php

use App\Core\Connection;

class MatchM extends Table {
    CONST CLE_CRON = ['bot' => 'r1NMMY63qk1jAkFa6dvU', 'admin' => 'QRift15I5222Ib1FZp3T'];
    CONST DEFAULT_TEAM = 45;
    private $match_count = 0;

    public static function factory():self {
        return new MatchM(Connection::getInstance());
    }

    public function addUpdateMatch($id_match, $numb_match, $coupe, $club_in, $initiale_in, $club_out, $initiale_out, $score, $arbitre, $id_categorie, $id_piscine, $id_saison, $date_match) {
        $this->existWPO($id_match)
            ? $this->updateMatch($id_match, $score, $arbitre, $id_piscine, $date_match)
            : $this->addMatch($id_match, $numb_match, $coupe, $club_in, $initiale_in, $club_out, $initiale_out, $score, $arbitre, $id_categorie, $id_piscine, $id_saison, $date_match);
    }

    public function addMatch ($id_match, $numb_match, $coupe, $club_in, $initiale_in, $club_out, $initiale_out, $score, $arbitre, $id_categorie, $id_piscine, $id_saison, $date_match) {
        $this -> bdd-> req('INSERT INTO t_match (mac_id_wpo, mac_numb, mac_coupe, mac_club_in, mac_initiale_in, mac_club_out, mac_initiale_out, mac_score, mac_arbitre, mac_id_categorie, mac_id_piscine, mac_date, mac_id_saison, mac_date_modif) VALUES (:id_match, :numb_match, :coupe, :club_in, :initiale_in, :club_out, :initiale_out, :score, :arbitre, :id_categorie, :id_piscine, :date_match, :id_saison, NOW())',
            ['id_match'=>$id_match, 'numb_match' => $numb_match, 'coupe'=>$coupe, 'club_in'=> $club_in, 'initiale_in'=>$initiale_in, 'club_out'=>$club_out, 'initiale_out'=>$initiale_out, 'score'=> $score, 'arbitre'=>$arbitre, 'id_categorie'=>$id_categorie, 'id_piscine' => $id_piscine, 'date_match' => $date_match, 'id_saison' => $id_saison]);
    }

    public function updateMatch ($id_match, $score, $arbitre, $id_piscine, $date_match) {
        $this -> bdd-> req('UPDATE t_match SET mac_score = :score, mac_arbitre = :arbitre, mac_id_piscine = :id_piscine, mac_date = :date_match, mac_date_modif = NOW() WHERE mac_id_wpo = :id_match  ',
            ['id_match'=>$id_match, 'score'=> $score, 'arbitre'=>$arbitre, 'id_piscine' => $id_piscine, 'date_match' => $date_match]);
    }

    public function existWPO($id_match) {
        $result = $this->bdd->reqSingle('SELECT count(mac_id) as count FROM t_match WHERE mac_id_wpo = :id_match', ['id_match' => $id_match]);
        return $result['count'] > 0;
    }

    public function getMatch($id_match){
        return $this -> bdd -> reqSingle('SELECT mac_numb as numb_match, mac_coupe, mac_club_in as club_in, mac_score as score, mac_club_out as club_out, mac_date, mac_arbitre, mac_id_categorie as id_categorie, mac_id_piscine as id_piscine FROM t_match WHERE mac_id = :id_match', ['id_match' => $id_match]);
    }

    public function getCalendrier($id_saison, $id_categorie){
        return $this -> bdd -> reqMulti('SELECT mac_id, mac_coupe, mac_club_in as club_in, mac_initiale_in as init_in, mac_club_out as club_out, mac_initiale_out as init_out, mac_date, mac_score as score, mac_id_saison FROM t_match WHERE mac_id_categorie = :id_categorie AND mac_id_saison = :id_saison AND mac_supp = 0 ORDER BY mac_date', ['id_categorie'=>$id_categorie, 'id_saison' => $id_saison]);
    }

    public function getNextWeekMatchs() {
        return $this -> bdd -> reqMulti('SELECT mac_club_in as club_in, mac_initiale_in as initiale_in , mac_club_out as club_out, mac_initiale_out as initiale_out, mac_date as date, pis_ville as ville, cat_categorie as categorie, @id_section:=2 as id_section FROM t_match 
                                           INNER JOIN t_piscine ON pis_id = mac_id_piscine
                                           INNER JOIN t_categorie cat ON mac_id_categorie = cat_id
                                           WHERE mac_date > NOW() AND mac_date <= NOW() + INTERVAL 7 DAY ORDER BY mac_date');
    }

    public function setParams(array $match, int $id_curentSaison): array {
        $match['mac_date'] = new DateTime($match['mac_date']);
        $match['color'] = $this->defineColorTd($match['mac_date'], $id_curentSaison, $match['mac_id_saison']);

        return $match;
    }

    public function setsParams(array $matchs, int $id_curentSaison): array {
        foreach ($matchs as $key => $match) {
            $matchs[$key] = $this->setParams($match, $id_curentSaison);
        }

        return $matchs;
    }

    public function getUrlMacthWpo($id_match) {
        return 'https://www.waterpolo-online.com/match/?MatchId=WW'.$id_match.'&Report=NO';
    }

    private function defineColorTd (DateTime $dateMatch, int $id_curentSaison, int $id_matchSaison):string {
        if(time() > $dateMatch->getTimestamp() || $id_curentSaison != $id_matchSaison){
            return ' grey';
        }

        if($this->match_count == 0 && $id_curentSaison == $id_matchSaison && time() < $dateMatch->getTimestamp()){
            $this->match_count = 1;
            return  ' bold';
        }

        return ' black';
    }
}

/*
$this -> bdd-> req('INSERT INTO t_match (mac_id_wpo, mac_numb, mac_coupe, mac_club_in, mac_initiale_in, mac_club_out, mac_initiale_out, mac_score, mac_arbitre, mac_id_categorie, mac_id_piscine, mac_date, mac_id_saison, mac_date_modif) VALUES (:id_match, :numb_match, :coupe, :club_in, :initiale_in, :club_out, :initiale_out, :score, :arbitre, :id_categorie, :id_piscine, :date_match, :id_saison, NOW())
ON DUPLICATE KEY UPDATE mac_id_wpo = :id_match, mac_numb = :numb_match, mac_coupe = :coupe, mac_club_in = :club_in, mac_initiale_in = :initiale_in, mac_club_out = :club_out, mac_initiale_out = :initiale_out, mac_score = :score, mac_arbitre = :arbitre, mac_id_categorie = :id_categorie, mac_id_piscine = :id_piscine, mac_date = :date_match, mac_id_saison = :id_saison, mac_date_modif = NOW();',
['id_match'=>$id_match, 'numb_match' => $numb_match, 'coupe'=>$coupe, 'club_in'=> $club_in, 'initiale_in'=>$initiale_in, 'club_out'=>$club_out, 'initiale_out'=>$initiale_out, 'score'=> $score, 'arbitre'=>$arbitre, 'id_categorie'=>$id_categorie, 'id_piscine' => $id_piscine, 'date_match' => $date_match, 'id_saison' => $id_saison]);
 */
