<?php
use Connection\Connection;
class Saison extends Table {
    public static function factory() {
        $dbb = Connection::getInstance();
        $instance = new Saison($dbb);

        return $instance;
    }

    public function getSaison($id_saison){
        return $this -> bdd ->reqSingle('SELECT sai_ID, sai_saison FROM t_saison WHERE sai_ID = :id_saison', ['id_saison' => $id_saison]);
    }

    public function getSaisons(){
        return $this -> bdd ->reqMulti('SELECT sai_ID, sai_saison FROM t_saison ORDER BY sai_saison DESC ');
    }

    public function getSaisonsByCompetition($id_section){
        return $this -> bdd ->reqMulti('SELECT DISTINCT sai_ID, sai_saison FROM t_saison
                                          INNER JOIN t_competition ON com_id_saison = sai_ID
                                          WHERE sai_supplogiq = 0 AND com_id_section = :id_section ORDER BY sai_saison DESC ', ['id_section' => $id_section]);
    }

    public function getSaisonAlbumBySection($id_section){
        return $this->bdd->reqMulti('SELECT sai_ID, sai_saison FROM t_album 
                                       INNER JOIN t_saison ON sai_ID = alb_id_saison
                                       WHERE alb_id_section = :id_section AND alb_supplogique = 0 GROUP BY sai_ID ORDER BY sai_saison DESC', ['id_section' => $id_section]);
    }

        public function getSaisonsByPoloCategorie(){
        return $this -> bdd ->reqMulti('SELECT DISTINCT sai_ID, sai_saison FROM t_saison
                                          INNER JOIN t_equipe_saison ON equ_ID_saison = sai_ID
                                          WHERE sai_supplogiq = 0 ORDER BY sai_saison DESC ');
    }

    public function getLastSaisonPolo() {
        $saison = $this -> bdd ->reqSingle('SELECT DISTINCT max(sai_ID) as sai_id FROM t_saison
                                             INNER JOIN t_equipe_saison ON equ_ID_saison = sai_ID
                                             WHERE sai_supplogiq = 0');

        return $saison['sai_id'];
    }

    public function getLastSaisonCompetition($id_section){
        $saison = $this -> bdd ->reqSingle('SELECT DISTINCT max(sai_ID) as sai_ID FROM t_saison
                                             INNER JOIN t_competition ON com_id_saison = sai_ID
                                             WHERE sai_supplogiq = 0 AND com_id_section = :id_section', ['id_section' => $id_section]);
        return $saison['sai_ID'];
    }

    public function getSaisonLabel($id_saison){
        $saison = $this-> bdd ->reqSingle('SELECT sai_ID, sai_saison FROM t_saison WHERE sai_ID = :id_saison', ['id_saison' => $id_saison]);
        return $saison['sai_saison'];
    }

    public function saisonActive($array = true){

        $id_saison = $this -> bdd->reqSingle('SELECT sai_ID, sai_saison FROM t_saison WHERE sai_active = 1');

        if($array == false){return $id_saison['sai_ID'];}
        return $id_saison;
    }

    public function idToSaison(array $saisons):array {
        $array = [];

        foreach ($saisons as $saison) {
            $array[$saison['sai_ID']] = $saison['sai_saison'];
        }

        return $array;
    }
}