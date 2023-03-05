<?php

use App\Core\Connection;

class Sponsor extends Table {
    CONST URL_LOGO = '/logo/';
    CONST URL_REAL_PATH = '/images/logo/';
    CONST EXT_LOGO = ['jpeg', 'jpg', 'png'];
    CONST SIZE_LOGO = '500000';
    CONST DIM_LOGO = ['1000', '1000'];

    public static function factory():self {
        return new Sponsor(Connection::getInstance());
    }

    public function addSponsor($nom, $id_section, $numb, $rue, $cp, $ville, $tel, $mail, $site, $description, $nom_logo, $id_domaine) {
        $this -> bdd -> req('INSERT INTO t_sponsor (spo_nom, spo_id_section, spo_rue, spo_numb, spo_cp, spo_ville, spo_tel, spo_mail, spo_site, spo_description, spo_logo, spo_id_domaine, spo_nom_modif, spo_date_modif) VALUES (:nom, :id_section, :rue, :numb, :cp, :ville, :tel, :mail, :site , :description, :nom_logo, :id_domaine, :nom_modif, NOW())', ['nom'=> $nom, 'id_section' => $id_section, 'numb' => $numb, 'rue' => ucfirst(mb_strtolower($rue)), 'cp' => $cp, 'ville'=> mb_strtoupper($ville), 'tel' => $tel, 'mail' => $mail, 'site' => $site, 'description' => htmlspecialchars($description), 'nom_logo' => $nom_logo, 'id_domaine' => $id_domaine, 'nom_modif' => $_SESSION['auth']['user']]);
        return $this -> bdd -> last();
    }

    public function updateSponsor ($id_sponsor, $nom, $id_section, $numb, $rue, $cp, $ville, $tel, $mail, $site, $description, $nom_logo, $id_domaine) {
        $this -> bdd-> req ('UPDATE t_sponsor SET spo_nom = :nom, spo_id_section = :id_section, spo_rue = :rue, spo_numb = :numb, spo_cp=:cp, spo_ville=:ville, spo_tel=:tel, spo_mail=:mail, spo_site=:site, spo_description=:description, spo_logo=:nom_logo, spo_id_domaine=:id_domaine, spo_nom_modif=:nom_modif, spo_date_modif=NOW() WHERE spo_id=:id_sponsor',
                            array('id_sponsor' => $id_sponsor,'nom'=> $nom, 'id_section' => $id_section, 'numb' => $numb, 'rue' => ucfirst(mb_strtolower($rue)), 'cp' => $cp, 'ville'=> mb_strtoupper($ville), 'tel' => $tel, 'mail' => $mail, 'site' => $site, 'description' => htmlspecialchars($description), 'nom_logo' => $nom_logo, 'id_domaine' => $id_domaine, 'nom_modif' => $_SESSION['auth']['user']));
    }

    public function updateSponsorByName ($nom, $id_section, $numb, $rue, $cp, $ville, $tel, $mail, $site, $description, $nom_logo, $id_domaine) {
        $this -> bdd-> req ('UPDATE t_sponsor SET spo_id_section = :id_section, spo_rue = :rue, spo_numb = :numb, spo_cp=:cp, spo_ville=:ville, spo_tel=:tel, spo_mail=:mail, spo_site=:site, spo_description=:description, spo_logo=:nom_logo, spo_id_domaine=:id_domaine, spo_nom_modif=:nom_modif, spo_date_modif=NOW(), spo_supplogiq = 0 WHERE spo_nom= :nom', ['nom'=> $nom, 'id_section' => $id_section, 'numb' => $numb, 'rue' => ucfirst(mb_strtolower($rue)), 'cp' => $cp, 'ville'=> mb_strtoupper($ville), 'tel' => $tel, 'mail' => $mail, 'site' => $site, 'description' => htmlspecialchars($description), 'nom_logo' => $nom_logo, 'id_domaine' => $id_domaine, 'nom_modif' => $_SESSION['auth']['user']]);
    }

    public function getSponsorsBySection($id_section = 'all'){

        if(in_array($id_section, array(1,2,3))){
            $id_section = '4,'.$id_section;
        } elseif($id_section == 'all') {
            $id_section = '1,2,3,4';
        }

        return $this -> bdd-> reqMulti('SELECT spo_id, spo_nom, spo_logo  FROM t_sponsor WHERE spo_supplogiq = 0 AND spo_id_section IN ('.$id_section.') ORDER BY spo_nom');
    }
    
    public function getSponsor($id_sponsor){
        return $this -> bdd-> reqSingle('SELECT spo_id, spo_nom as nom, spo_logo as logo , spo_description as description, spo_rue as rue_sponsor, spo_numb as numb_sponsor, spo_cp as cp_sponsor, spo_ville as ville_sponsor, spo_tel as tel, spo_mail as mail, spo_site as site, spo_id_domaine as id_domaine, spo_id_section as id_section, spo_supplogiq FROM t_sponsor WHERE spo_id=:id_sponsor', array('id_sponsor'=>$id_sponsor));
    }

    public function getLogoByID ($id_sponsor) {
        return $this->bdd->reqSingle('SELECT spo_logo FROM t_sponsor WHERE spo_id = :id_sponsor', ['id_sponsor'=>$id_sponsor]);
    }

    public function getLogoByNom ($nom) {
        return $this->bdd->reqSingle('SELECT spo_logo FROM t_sponsor WHERE spo_nom = :nom', array('nom'=>$nom));
    }

    public function getDomaines(){
        return $this -> bdd-> reqMulti('SELECT dom_id, dom_nom FROM t_domaine WHERE dom_supplogiq = 0 ORDER BY dom_nom');
    }

    public function suppSponsor($id_sponsor){
        $supp = $this -> bdd-> req ('UPDATE t_sponsor SET spo_supplogiq = 1, spo_nom_modif = :nom_modif, spo_date_modif = NOW() WHERE spo_id = :id_sponsor', array('nom_modif' => $_SESSION['auth']['user'],'id_sponsor'=>$id_sponsor));
        return $supp -> rowCount();
    }
    
    public function getSponsorByname($nom){
        return $sponsor = $this -> bdd-> reqSingle('SELECT spo_id, spo_logo, spo_supplogiq FROM t_sponsor WHERE spo_nom=:nom',array('nom'=>$nom));
    }

    public function idToName(array $domaines):array {
        $array = [];

        foreach($domaines as $domaine) {
            $array[$domaine['dom_id']] = $domaine['dom_nom'];
        }

        return $array;
    }
}
