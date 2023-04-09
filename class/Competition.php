<?php
use \Connection\Connection;
class Competition extends Table {
    CONST S_ANNULE = 0;
    CONST S_PRESENT = 1;
    CONST S_PAS_PRESENT = 2;
    CONST FICHIER_SIZE = 5048000;
    CONST FICHIER_EXT = ['pdf'];
    CONST FICHIER_URL = '/competition/';
    CONST FICHIER_REAL_PATH = '/documents/competition/';

    public static function factory(){
        $dbb = Connection::getInstance();
        $instance = new Competition($dbb);

        return $instance;
    }

    public function addCompetition($nom, $statut, $id_saison, $date_in, $date_out, $heure, $id_piscine, $id_section, $resultat, $liste = NULL,$programme = NULL) {
        $this -> bdd -> req('INSERT INTO t_competition (com_nom, com_statut, com_id_saison, com_date_in, com_date_out, com_heure ,com_id_piscine, com_liste, com_programme, com_resultat, com_id_section, com_nom_creation, com_date_modif) VALUES (:nom, :statut, :id_saison, :date_in, :date_out, :heure, :id_piscine, :liste, :programme, :resultat, :id_section, :nom_creation, NOW())', ['nom' => $nom, 'statut' => $statut, 'id_saison' => $id_saison, 'date_in' => $date_in, 'date_out' => $date_out, 'heure' => $heure, 'id_piscine' => $id_piscine, 'liste' => $liste, 'programme' => $programme, 'resultat' => $resultat, 'id_section' => $id_section, 'nom_creation' => $_SESSION['auth']['user']]);

        return $this -> bdd->last();
    }

    public function updateCompetition($nom, $statut, $id_saison, $date_in, $date_out, $heure, $programme, $liste, $resultat, $id_piscine, $id_competition) {
        $this -> bdd -> req('UPDATE t_competition SET com_nom=:nom, com_statut=:statut, com_id_saison=:id_saison, com_date_in=:date_in, com_date_out=:date_out, com_heure=:heure , com_programme = :programme, com_liste = :liste, com_resultat = :resultat, com_id_piscine=:id_piscine, com_supplogiq = 0, com_nom_modif=:nom_modif, com_nom_modif=:nom_modif, com_date_modif=NOW() WHERE com_id=:id_competition',['nom' => $nom, 'statut' => $statut, 'id_saison' => $id_saison, 'date_in' => $date_in, 'date_out' => $date_out, 'heure' => $heure, 'programme' => $programme, 'liste' => $liste, 'resultat' => $resultat, 'id_piscine' => $id_piscine, 'nom_modif' => $_SESSION['auth']['user'], 'id_competition' => $id_competition]);
    }

    public function updatePath($type, $fichier, $id_competition) {
        $this -> bdd -> req('UPDATE t_competition SET com_' . $type . ' = :fichier, com_nom_modif = :nom_modif, com_date_modif = NOW() WHERE com_id=:id_competition',['fichier' => $fichier, 'nom_modif' => $_SESSION['auth']['user'], 'id_competition' => $id_competition]);
    }

    public function suppCompetition($ID_competition){
        $supp = $this-> bdd -> req('UPDATE t_competition SET com_supplogiq = 1, com_nom_modif=:nom, com_date_modif=NOW() WHERE com_id=:ID_competition', array('nom' => $_SESSION['auth']['user'] , 'ID_competition' => $ID_competition));
        return $supp -> rowCount();
    }

    public function getCompetition($id_competition){
        return $this->bdd->reqSingle('SELECT com_id, com_nom as nom_competition, pis_id as id_piscine, pis_nom as nom_piscine, pis_numb as numb_piscine, pis_rue as rue_piscine, pis_cp as cp_piscine, pis_ville as ville_piscine, com_date_in as date_in, com_date_out as date_out, com_heure as heure, com_liste as liste, com_resultat as resultat, com_programme as programme, com_statut as statut, sai_saison FROM t_competition 
                                       INNER JOIN t_saison ON com_id_saison = sai_ID
                                       LEFT JOIN t_piscine ON com_id_piscine = pis_id
                                       WHERE com_id=:id_competition', ['id_competition' => $id_competition]);
    }

    public function getAllCompetition($id_section, $id_saison){
        return $this->bdd-> reqMulti('SELECT com_id, com_nom , com_id_saison, com_id_section as id_section, com_date_in as date_in, com_date_out as date_out, com_liste , com_resultat, com_programme, com_statut FROM t_competition
                                         INNER JOIN t_saison sai ON com_id_saison = sai_ID
                                         WHERE com_supplogiq = 0 AND com_id_section = :id_section AND com_id_saison = :id_saison ORDER BY com_date_in', array('id_section' => $id_section, 'id_saison' => $id_saison));
    }

    public function getNextWeekCompetitions() {
         return $this->bdd->reqMulti('SELECT com_nom as nom_competition, pis_ville as ville_piscine, com_date_in as date_in, com_date_out as date_out, com_heure as heure, com_id_section as id_section FROM t_competition 
                                        INNER JOIN t_piscine ON com_id_piscine = pis_id
                                        WHERE com_date_in > NOW() AND com_date_in <= NOW() + INTERVAL 7 DAY ORDER BY com_date_in');
    }

    public function getEquipes(){
        return $this->bdd->reqMulti('SELECT club_ID, club_nom, club_initiale FROM t_club ORDER BY club_initiale');
    }

    public function setFicheParams(array $competition): array {
        $competition['date_in'] = new DateTime($competition['date_in']);
        $competition['date_out'] = $competition['date_out'] != null ? new DateTime($competition['date_out']): null;
        $competition['date'] = $this->defineDateFiche($competition['date_in'], $competition['date_out']);
        $competition['statutLogo'] = $this->defineLogoParticipation($competition['statut']);
        $competition['link'] = $this->defineLinkBtnDl($competition['liste'], $competition['programme'], $competition['resultat']);
        $competition['options'] = $this->defineOptions($competition['liste'], $competition['programme'], $competition['resultat']);

        return $competition;
    }

    public function setCalendrierParams(array $competition, array $log): array {
        $competition['date_in'] = new DateTime($competition['date_in']);
        $competition['date_out'] = $competition['date_out'] != null ? new DateTime($competition['date_out']): null;
        $competition['date'] = $this->defineDateCalendrier($competition['date_in'], $competition['date_out']);
        $competition['statutLogo'] = $this->defineLogoParticipation($competition['com_statut']);
        $competition['dl_liste'] = $this->generate_dl($competition, 'liste', $log);
        $competition['dl_programme'] = $this->generate_dl($competition, 'programme', $log);
        $competition['dl_resultat'] = $this->generate_dl($competition, 'resultat', $log);

        return $competition;
    }

    public function setsCalendrierParams(array $competitions, array $log):array {
        foreach ($competitions as $key => $competition) {
            $competitions[$key] = $this->setCalendrierParams($competition, $log);
        }

        return $competitions;
    }

    private function defineDateCalendrier(DateTime $dateIn, $dateOut): string {
        if($dateOut instanceof DateTime){

            if($dateIn->format('m') == $dateOut->format('m')){
                return $dateIn->format('d').' - '.$dateOut->format('d').'/'.$dateOut->format('m');
            }

            return $dateIn->format('d').'/'.$dateIn->format('m').' - '.$dateOut->format('d').'/'.$dateOut->format('m');
        }

        return $dateIn->format('d/m');
    }

    private function defineDateFiche(DateTime $dateIn, $dateOut): string {
        if ($dateOut instanceof DateTime) {
            return 'du ' . $dateIn->format('d/m/Y') . ' au ' . $dateOut->format('d/m/Y');
        }

        return $dateIn->format('d/m/Y');
    }

    private function defineLinkBtnDl($liste, $programme, $resultat) {
        if(!empty($liste) && file_exists(__DIR__ . '/../..' . Competition::FICHIER_REAL_PATH . $liste)) {
            return $liste;
        }

        if(!empty($programme) && file_exists(__DIR__ . '/..' . Competition::FICHIER_REAL_PATH . $programme)) {
            return $programme;
        }

        if(!empty($resultat) && file_exists(__DIR__ . '/..' . Competition::FICHIER_REAL_PATH . $resultat)) {
            return $resultat;
        }

        return null;
    }

    private function defineOptions($liste, $programme, $resultat) {
        $option = '';
        if(!empty($liste) && file_exists(__DIR__ . '/..' . Competition::FICHIER_REAL_PATH . $liste)){
            $option = '<option value="'.Competition::FICHIER_URL.$liste.'"> Liste des participants </option>';
        }

        if(!empty($programme) && file_exists(__DIR__ . '/..' . Competition::FICHIER_REAL_PATH . $programme)){
            $option .= '<option value="'.Competition::FICHIER_URL.$programme.'"> Programme </option>';
        }

        if(!empty($resultat) && file_exists(__DIR__ . '/..' . Competition::FICHIER_REAL_PATH . $resultat)){
            $option .= '<option value="'.Competition::FICHIER_URL.$resultat.'"> Résultats </option>';
        }

        return $option;
    }

    private function generate_dl (array $competition, string $key, array $log):string {
        if (($key == 'liste' || $key == 'programme') && $competition['id_section'] == Section::PLONGEON['id']) {
            return '';
        }

        if($competition['com_' . $key] != null && file_exists(__DIR__ . '/../'.Competition::FICHIER_REAL_PATH.$competition['com_' . $key])){
            return '<td  class="text-center hidden-xs hidden-sm"> <a href="'.Competition::FICHIER_URL.$competition['com_' . $key].'" target="_blank" ><span class="glyphicon glyphicon-download "></span></a></td>';

        }

        if(($log['droit'] == Droit::RESP || $log['droit'] == Droit::ADMIN )) {
            return '<td  class="text-center hidden-xs hidden-sm">'
                .           '<label class="add-fichier">'
                .              '<span class="glyphicon glyphicon-upload color-success" style="color:green"></span>'
                .               '<input type="file" name="' . $key . '" data-upload="file" style="display: none;" />'
                .           '</label>'
                .       '</td>';

        }

        return '<td  class="text-center hidden-xs hidden-sm"> - </td>';
    }

    private function defineLogoParticipation($statut) {
        if ($statut == Competition::S_PRESENT) {
            return Core_rbp::icon('ok', '#5cb85c');
        }

        if ($statut == Competition::S_PAS_PRESENT) {
            return Core_rbp::icon('alert', 'darkorange');
        }

        return Core_rbp::icon('remove', 'red');
    }
}