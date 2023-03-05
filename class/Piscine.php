<?php

use App\Core\Connection;

class Piscine extends Table {
    public static function factory():self{
        return new Piscine(Connection::getInstance());
    }

    public function addPiscine($nom, $numb, $rue, $cp, $ville){
        $this-> bdd -> req ('INSERT INTO t_piscine (pis_nom, pis_numb, pis_rue, pis_cp, pis_ville, pis_nom_modif, pis_date_modif) VALUES (:nom, :numb, :rue, :cp, :ville, :nom_modif, NOW())', ['nom' => $nom, 'numb' => $numb, 'rue' =>ucfirst(mb_strtolower($rue)), 'cp'=>$cp, 'ville'=>mb_strtoupper($ville), 'nom_modif'=>$_SESSION['auth']['user']]);
        return $this -> bdd -> last();
    }

    public function updatePiscine ($nom, $numb, $rue, $cp, $ville, $id_piscine) {
        $this->bdd->req('UPDATE t_piscine SET pis_nom = :nom, pis_numb = :numb, pis_rue = :rue, pis_cp = :cp,  pis_ville = :ville, pis_nom_modif = :nom_modif, pis_date_modif = NOW() WHERE pis_id = :id_piscine', array('nom' => $nom, 'numb' => $numb, 'rue' => ucfirst(mb_strtolower($rue)), 'cp' => $cp, 'ville' => mb_strtoupper($ville), 'nom_modif' => $_SESSION['auth']['user'], 'id_piscine' => $id_piscine));
    }

    public function suppPiscine($id_piscine) {
        $this->bdd->req('UPDATE t_piscine SET pis_supplogique = 1, pis_nom_modif = :nom_modif, pis_date_modif = NOW() WHERE pis_id = :id_piscine', ['id_piscine' => $id_piscine, 'nom_modif' => $_SESSION['auth']['user']]);
    }

    public function activatePiscine($id_piscine) {
        $this->bdd->req('UPDATE t_piscine SET pis_supplogique = 0, pis_nom_modif = :nom_modif, pis_date_modif = NOW() WHERE pis_id', ['id_piscine' => $id_piscine, 'nom_modif' => $_SESSION['auth']['user']]);
    }

    public function getPiscines() {
        return $this -> bdd -> reqMulti('SELECT pis_id, pis_nom, pis_numb, pis_rue, pis_ville, pis_cp FROM t_piscine WHERE pis_supplogique = 0 ORDER BY pis_ville, pis_nom');
    }

    public function getPiscineByID($id_piscine) {
        return $this -> bdd -> reqSingle('SELECT pis_id, pis_nom as nom_piscine, pis_numb as numbRue_piscine, pis_rue as rue_piscine, pis_ville as ville_piscine, pis_cp as cp_piscine FROM t_piscine WHERE pis_id = :id_piscine', ['id_piscine' => $id_piscine]);
    }

    public function getPiscineByAdresse($numb, $rue, $cp, $ville) {
        return $this -> bdd -> reqSingle('SELECT pis_id, pis_supplogique FROM t_piscine WHERE pis_numb = :numb AND pis_rue = :rue AND pis_cp = :cp AND pis_ville = :ville', ['numb' => $numb, 'rue' => $rue, 'cp' => $cp, 'ville' => strtoupper($ville)]);
    }

    public function getPiscinesWithWpoName() {
        return $this -> bdd -> reqMulti('SELECT pis_id, pis_nom_wpo FROM t_piscine WHERE  pis_nom_wpo IS NOT NULL');
    }

    public function recherchePiscine($search):array {
        return $this->bdd->reqMulti("SELECT pis_id as id_piscine, pis_nom as nom, pis_ville as ville from t_piscine WHERE pis_supplogique = 0 AND CONCAT(pis_ville,' - ',pis_nom) LIKE UPPER('".$search."%')");
    }

    public function orderAssociateNameWpo($piscines) {
        $array = [];

        foreach ($piscines as $piscine) {
            $array[$piscine['pis_nom_wpo']] = $piscine['pis_id'];
        }

        return $array;
    }

    public function arrayIdToName(array $piscines):array {
        $array = [];

        foreach ($piscines as $piscine) {
            $array[$piscine['id_piscine']] = $piscine['ville'].' - '.$piscine['nom'];
        }

        return $array;
    }
}
