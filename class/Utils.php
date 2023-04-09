<?php
class Utils {
    private $erreur;

    public static function factory() {
        return new Utils();
    }

    public function setErreur($erreur) {
        $this->erreur = $erreur;
    }

    public function getErreur () {
        return $this->erreur;
    }

    public function checkSelect($select) {
        if(is_numeric($select) && $select != -1){
            return true;
        }
        return false;
    }

    public function checkSlug($slug) {
        if(preg_match("#^[a-z0-9-]{0,100}$#", $slug)){
            return true;
        }
        return false;
    }

    public function checkNom($nom) {
        if(preg_match("/^[a-zA-ZÀ-ÿ’'._\s\-]{0,40}$/",$nom)){
            return true;
        }
        return false;
    }

    public function checkNomEvent($nom) {
        if(preg_match("#^[0-9a-zA-ZÀ-ÿ\s&\'-_()]{0,40}$#",$nom)){
            return true;
        }
        return false;
    }

    public function checkTitre($titre) {
        if(preg_match("#^[0-9a-zA-ZÀ-ÿ\s\'\-()\"!{}?,.;:/]{1,80}$#",$titre)){
            return true;
        }
        return false;
    }

    public function checkNumb($numb){
        if(is_numeric($numb) && !empty($numb)){
            return true;
        }
        return false;
    }

    public function checkDate($jour, $mois, $annee, $type){
        if(!is_numeric($jour) || $jour < 0  || $jour > 31){
            $this->setErreur("Jour invalide.");
            return false;
        }

        if(!is_numeric($mois) || $mois < 0  || $mois > 12){
            $this->setErreur("Mois invalide.");
            return false;
        }

        if(!preg_match('#^(19|20)[0-9]{2}$#',$annee)){
            $this->setErreur("Année invalide.");
            return false;
        }

        //Vérification de la cohérence par rapport au jour
        $max = '';

        switch(intval($mois)) {
            case 2:
                if($annee % 4 == 0) {$max = ($annee % 1000) ? 29 : 30;}
                else
                    $max = 28;
                break;

            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                $max = 31;
                break;

            case 4:
            case 6:
            case 9:
            case 11:
                $max = 30;
                break;
        }

        if($jour > $max){
            $this->setErreur("Le jour ne correspond pas au mois.");
            return false;
        }

        //Verrification du moi et de l'année
        if($type == 'passe'){
            if($annee > date("Y")){
                $this->setErreur("La date n'est pas dans le passé.");
                return false;
            }

            elseif($mois > date("m") AND $annee == date("Y")){
                $this->setErreur("La date n'est pas dans le passé.");
                return false;
            }

            elseif($jour >= date("d") AND $mois == date("m") AND $annee == date("Y")){
                $this->setErreur("La date n'est pas dans le passé.");
                return false;
            }

        } elseif ($type == 'scolaire'){
            /* Définition des années valides*/
            $annee_valide = self::Annee_valide();

            if(($mois < 9 && $annee == $annee_valide['0']) || ($mois > 8 && $annee == $annee_valide['1']) || !in_array($annee, $annee_valide)) {
                $this->setErreur("La date doit faire partie de la saison courante.");
                return false;
            }

        } elseif($type == 'futur') {
            if($annee < date("Y")){
                $this->setErreur("La date n'est pas dans le futur.");
                return false;
            }

            elseif($mois < date("m") AND $annee == date("Y")){
                $this->setErreur("La date n'est pas dans le futur.");
                return false;
            }

            elseif($jour <= date("d") AND $mois == date("m") AND $annee == date("Y")){
                $this->setErreur("La date n'est pas dans le futur.");
                return false;
            }
        }

        return true;
    }

    public function checkHeure($heure, $minute){
        if(empty($heure) ||!is_numeric($heure) || ($heure > 24 && $heure < 0)){
            return false;
        }

        /*Vérification des minutes */
        if(empty($minute) || !is_numeric($minute) ||($minute > 60 && $minute < 0 )){
            return false;
        }

        return true;
    }

    public function checkNumbAdresse($numb){
        if(!preg_match("^[0-9]{1,5}[0-9A-Za-z\s-]{0,5}$^",$numb) || $numb == 0){
            return false;

        }

        return true;
    }

    public  function checkCp($cp){
        if(!preg_match("^[1-9]{1}[0-9]{3,4}$^",$cp)){
            return false;

        }

        return true;
    }

    public function checkTelephone($numb){
        if(!preg_match("#^[0-9/\.]{1,30}$#",$numb)){
            return false;
        }

        return true;
    }

    public function checkMail($mail){
        if(!preg_match("#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#",$mail)){
            return false;
        }

        return true;
    }

    public function checkAdresse ($post, $name) {
        $input_complete = 0;

        if(!empty($post["rue_" . $name])){
            $input_complete ++;
        }

        if(!empty($post["cp_" . $name])){
            $input_complete ++;
        }

        if(!empty($post["ville_" . $name])){
            $input_complete ++;
        }

        if($input_complete != 0 && $input_complete != 3) {
            return false;
        }

        if(!empty($post["numbRue_" . $name]) && $input_complete != 3 ) {
            return false;
        }

        return true;
    }

    public function checkSite($site){
        if(!preg_match("#^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$#",$site)){
            return false;
        }

        return true;
    }

    public function checkMdp($mdp1) {
        if(!preg_match("#^([0-9A-Za-z$@%*+\\-_!?,.;:=]+){6,25}$#",$mdp1)){
            return false;
        }

        return true;
    }

    public function checkFichier($name, $extension, $size, $dimension = false){
        $file = new SplFileInfo($_FILES[$name]['name']);

        if ( $_FILES[$name]['error'] == UPLOAD_ERR_NO_FILE ) {return true;}

        /* Vérification du transfert */
        if ( $_FILES[$name]['error'] != UPLOAD_ERR_OK ) {
            $this->setErreur('Erreur de transfert.');
            return false;
        }

        if ( !in_array(strtolower($file ->getExtension()),$extension) ) {
            $this->setErreur('Extention invalide.');
            return false;
        }

        if ( filesize($_FILES[$name]['tmp_name']) > $size ) {
            $this->setErreur('Fichier trop volumineux.');
            return false;
        }

        /*Vérification la taille de l'image s'il y a besoin*/
        if ($dimension != '') {
            $dimensionFiles = getimagesize($_FILES[$name]['tmp_name']);

            if ($dimensionFiles['0'] > $dimension['0'] || $dimensionFiles['1'] > $dimension['1']) {
                $this->setErreur('Dimensions incorrectes.');
                return false;
            }
        }

        return true;
    }

    public function checkEmptyForm($array){

        $test = true;

        foreach($array as $key => $value) {

            if ($key == "civilite" && $value != "-1") {
                $test = false;
            }

            if ($key == "section") {
                foreach ($value as $section) {
                    if($section != ""){
                        $test = false;
                    }
                }
            }

            if ($value != "" && !in_array($key, ['civilite', 'section'])) {
                $test = false;
            }
        }

        return $test;
    }

    public function checkNumbLicence($numb){

        if(!preg_match("^[0-9A-Za-z]{0,12}$^",$numb)){
            return false;
        }

        return true;
    }

    private  function Annee_valide(){

        $mois_actuel = date("m");
        $annee_actuel = date("Y");

        if($mois_actuel > '8'){

            return $annee_valide = array('0' => $annee_actuel, '1' => $annee_actuel+1);
        }

        else{

            return $annee_valide = array('0' =>  $annee_actuel - 1, '1' => $annee_actuel);
        }
    }
}
