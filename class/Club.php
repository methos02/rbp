<?php
use Connection\Connection;
class Club extends Table {

    CONST DEFAUT_PHOTO = 'inconnu.jpg';
    CONST URL_PORTRAIT = '/portrait/';
    CONST URL_REAL_PATH = '/images/portrait/';
    CONST EXT_PHOTO = ['jpeg', 'jpg'];
    CONST SIZE_PHOTO = '5000000';
    CONST DIM_PHOTO = ['3000', '3000'];

    public static function factory() {
        $dbb = Connection::getInstance();
        $instance = new Club($dbb);

        return $instance;
    }

    public function addMembreH($nom, $prenom, $id_civilite, $date_birth, $date_death, $bio, $photo) {
        $this->bdd->req('INSERT INTO t_membre_h(mem_nom, mem_prenom, mem_id_civilite, mem_date_birth, mem_date_death, mem_bio, mem_photo, mem_nom_modif, mem_date_modif) VALUES (:nom, :prenom ,:id_civilite, :date_birth ,:date_death ,:bio , :photo, :nom_modif, NOW())', ['nom'=> mb_strtoupper($nom), 'prenom'=>ucfirst($prenom), 'id_civilite'=> $id_civilite, 'date_birth'=> $date_birth, 'date_death'=> $date_death, 'bio'=>htmlspecialchars($bio), 'photo' => $photo, 'nom_modif' => $_SESSION['auth']['user']]);
        return $this->bdd->last();
    }

    public function updateMembreH($id_membre, $nom, $prenom, $id_civilite, $date_birth, $date_death, $bio, $photo){
        $update = $this -> bdd-> req('UPDATE t_membre_h SET mem_nom=:nom , mem_prenom=:prenom, mem_id_civilite = :id_civilite ,mem_date_birth=:date_birth, mem_date_death=:date_death, mem_bio=:bio, mem_photo=:photo, mem_nom_modif=:nom_modif, mem_date_modif=NOW() WHERE mem_ID=:id_membre',
                                    array('nom'=>mb_strtoupper($nom), 'prenom'=>ucfirst($prenom), 'id_civilite'=> $id_civilite, 'date_birth'=>$date_birth, 'date_death'=>$date_death, 'bio'=>htmlspecialchars($bio), 'photo'=> $photo, 'nom_modif'=>$_SESSION['auth']['user'], 'id_membre'=>$id_membre));
        return $update->rowCount();
    }

    public function suppMembreH($id_membre){
        $supp = $this-> bdd -> req('UPDATE t_membre_h SET mem_supplogiq = 1, mem_nom_modif=:nom, mem_date_modif=NOW() WHERE mem_ID=:id_membre', ['nom' => $_SESSION['auth']['user'] , 'id_membre' => $id_membre]);
        return $supp -> rowCount();
    }

    public function getPhoto($id_membre) {
        return $this -> bdd -> reqSingle('SELECT mem_photo FROM t_membre_h WHERE mem_ID=:id_membre', ['id_membre' => $id_membre]);
    }

    public function getAllMembreH() {
        return $this -> bdd-> reqMulti('SELECT * FROM t_membre_h WHERE mem_supplogiq = 0 ORDER BY mem_nom');
    }

    public function getMembreH($id_membre){
        return $this -> bdd-> reqSingle('SELECT mem_ID as id_membreH, mem_nom as nom, mem_prenom as prenom, mem_id_civilite as id_civilite, mem_date_birth as date_birth, mem_date_death as date_death, mem_bio as bio, mem_photo as photo, mem_supplogiq FROM t_membre_h WHERE mem_ID= :id_membre', array('id_membre'=>$id_membre));
    }

    public function getIdMembreHAlphabet(){
        $membre = $this -> bdd-> reqSingle('SELECT mem_id FROM t_membre_h ORDER BY mem_nom LIMIT 1');
        return $membre['mem_id'];
    }

    public function arrMembreIdToName($membres) {
        $array = [];

        foreach ($membres as $membre) {
            $array[$membre['mem_ID']] = $membre['mem_nom'] . ' ' . $membre['mem_prenom'];
        }

        return $array;
    }

    public function setParams(array $membre):array {
        $membre['date_birth'] = ($membre['date_birth'] != null)? new dateTime($membre['date_birth']): null;
        $membre['date_death'] = ($membre['date_death'] != null)? new dateTime($membre['date_death']): null;
        $membre['date'] = $this->defineDate($membre['date_birth'], $membre['date_death']);

        return $membre;
    }

    public function defineDate ($birth, $death):string {
        $date = $birth instanceof DateTime ? $birth->format('d/m/Y'): '';
        $date .= $death instanceof DateTime ? ' - ' . $death->format('d/m/Y'): '';
        return $date != ""? ' ('.$date.')': '';
    }
}