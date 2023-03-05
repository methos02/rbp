<?php

use App\Core\Connection;

class Adherent extends Table {
    CONST COTISATION = '5-6';
    CONST ID_SECTION = 0;
    CONST ID_FONCTION = 1;
    CONST ID_CATEGORIE = 2;

    CONST STATUT = [
        'vide' => '-----',
        'L' => "Pb de licence",
        'M' => "Pb de cotisation",
        'C' => "Pb de certificat",
        'A' => "Pb d'adresse",
        'T' => "Pb de téléphone",
        'E' => "Pb d'Email",
    ];

    CONST WHERE_STATUT = [
        'vide' => '',
        'L' => " AND ads_licence = 0",
        'M' => " AND ads_certif = 0",
        'C' => " AND ads_cotisation = 0",
        'A' => " AND adh_rue = ''",
        'T' => " AND adh_gsm = '' AND adh_tel = '' AND adh_gsm_mere = '' AND adh_gsm_pere = ''",
        'E' => " AND adh_mail = '' AND adh_mail_mere = '' AND adh_mail_pere = ''",
    ];

    public static function factory():self {
        return new Adherent(Connection::getInstance());
    }

    public function addAdherent($nom, $prenom, $date_birth, $civilite, $nationnalite){
        $this->bdd->req('INSERT INTO t_adherent (adh_nom , adh_prenom, adh_birth, adh_civilite, adh_nationalite, adh_nom_modif, adh_date_modif) VALUES (:nom, :prenom, :date_birth, :civilite, :nationalite, :nom_modif, NOW())', array( 'nom' => strtoupper($nom), 'prenom' => ucfirst ($prenom), 'date_birth' => $date_birth, 'civilite' => $civilite, 'nationalite'=> $nationnalite, 'nom_modif' => $_SESSION['auth']['user']));
        return $this->bdd->last();
    }

    public function addAdherentSaison($id_adherent) {
        $this->bdd->req('INSERT INTO t_adherent_saison (ads_id_adherent , ads_id_saison, ads_nom_modif, ads_date_modif) VALUES (:id_adherent, :id_saison, :nom_modif, NOW())', array( 'id_adherent' => $id_adherent, 'id_saison' => Saison::factory()->saisonActive(false), 'nom_modif' => $_SESSION['auth']['user']));
        return $this->bdd->last();
    }

    public function updateAdherent($nom, $prenom, $date_birth, $civilite, $nationnalite, $id_adherent){
        $update = $this->bdd->req('UPDATE t_adherent SET adh_nom = :nom, adh_prenom = :prenom, adh_birth = :date_birth, adh_civilite = :civilite, adh_nationalite = :nationalite, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_adherent', array( 'nom' => strtoupper($nom), 'prenom' => ucfirst ($prenom), 'date_birth' => $date_birth, 'civilite' => $civilite, 'nationalite'=> $nationnalite, 'nom_modif' => $_SESSION['auth']['user'], 'id_adherent' => $id_adherent));
        return $update->rowCount();
    }

    public function updateAdherentCoordonnee($numb, $rue, $cp, $ville, $numb2, $rue2, $cp2, $ville2, $tel, $gsm, $gsm_mere, $gsm_pere, $mail, $mail_mere, $mail_pere, $id_adherent) {
        $update = $this->bdd->req('UPDATE t_adherent SET adh_numb = :numb, adh_rue = :rue, adh_cp = :cp, adh_ville = :ville, adh_numb2 = :numb2, adh_rue2 = :rue2, adh_cp2 = :cp2, adh_ville2 = :ville2, adh_tel = :tel, adh_gsm = :gsm, adh_gsm_mere = :gsm_mere , adh_gsm_pere = :gsm_pere, adh_mail = :mail, adh_mail_mere = :mail_mere, adh_mail_pere = :mail_pere, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_adherent', array('numb' => $numb, 'rue' => $rue, 'cp' => $cp, 'ville' => $ville,'numb2'=>$numb2, 'rue2' => $rue2, 'cp2' => $cp2, 'ville2' => $ville2, 'tel' => $tel, 'gsm' => $gsm, 'gsm_mere' => $gsm_mere, 'gsm_pere' => $gsm_pere, 'mail' => $mail, 'mail_mere' => $mail_mere, 'mail_pere' => $mail_pere, 'nom_modif' => $_SESSION['auth']['user'], 'id_adherent' => $id_adherent));
        return $update->rowCount();
    }

    public function updateAdherentSaison($id_ads, $licence, $id_licence, $numb_licence, $date_licence, $certif, $date_certif, $cotisation, $id_cotisation, $date_cotisation, $montant_cotisation) {
        return $this->bdd->req('UPDATE t_adherent_saison SET ads_licence = :licence, ads_id_licence = :id_licence, ads_numb_licence = :numb_licence, ads_date_licence = :date_licence, ads_certif = :certif, ads_date_certif = :date_certif, ads_id_cotisation = :id_cotisation, ads_date_cotisation = :date_cotisation,ads_montant_cotisation = :montant_cotisation, ads_cotisation = :cotisation, ads_nom_modif = :nom_modif, ads_date_modif = NOW() WHERE ads_id = :id_ads', ['id_ads' => $id_ads, 'licence'=> $licence, 'id_licence' => $id_licence, 'numb_licence' => $numb_licence, 'date_licence' => $date_licence, 'certif' => $certif, 'date_certif' => $date_certif, 'cotisation' => $cotisation, 'id_cotisation' => $id_cotisation, 'date_cotisation' => $date_cotisation, 'montant_cotisation' => $montant_cotisation, 'nom_modif' => $_SESSION['auth']['user']]);
    }

    public function UpdateAdherentsCotisation($post) {
        $req = "";

        foreach($post as $id_adherent => $adherent) {
            $montant = (isset($adherent['montant']) && $adherent['montant'] != "")? $adherent['montant']: 'null' ;
            $ordre = $this->verifCotisation($adherent['id_cotisation'], $montant);


            $req .= 'UPDATE t_adherent_saison SET ads_id_cotisation = '.$adherent['id_cotisation'].', ads_montant_cotisation = '.$montant.', ads_cotisation = '.$ordre.', ads_date_modif = NOW(), ads_date_cotisation = NOW(), ads_nom_modif = "' . $_SESSION['auth']['user'] . '" WHERE ads_id = ' . $id_adherent . ';';
        }

        $this->bdd->req($req);
    }

    public function reinscrire($id_adherent) {
        $this->bdd->req('UPDATE t_adherent SET adh_inscrit = 1,  adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_adherent', ['nom_modif' => $_SESSION['auth']['user'], 'id_adherent' => $id_adherent]);
    }

    public function preInscrire($id_adherent) {
        $this->bdd->req('UPDATE t_adherent SET adh_preinscrit = 1,  adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_adherent', ['nom_modif' => $_SESSION['auth']['user'], 'id_adherent' => $id_adherent]);
    }

    public function addOrUpdateCategories($req) {
        $this->bdd->req('INSERT INTO t_adherent_categorie (adc_id_update, adc_id_adh_saison, adc_id_section, adc_id_fonction, adc_id_categorie, adc_nom_modif, adc_date_modif) VALUES ' . $req . ' 
                                ON DUPLICATE KEY UPDATE adc_supp = 0, adc_nom_modif = :nom_modif, adc_date_modif = NOW();', ['nom_modif' => $_SESSION['auth']['user']]);
    }

    public function prepReqCategories(array $categories, $id_ads):string {
        $req = '';

        foreach ($categories as $category) {
            $req .= "('" . $this->defineUniqCatId($id_ads, $category['id_section'], $category['id_fonction'], $category['id_categorie']) . "'," . $id_ads . "," . $category['id_section'] . "," . $category['id_fonction'] . "," . $category['id_categorie'] . ", :nom_modif, NOW()),";
        }

        return substr($req, 0, -1);
    }

    public function addOrUpdateCs($req) {
        $this->bdd->req('INSERT INTO t_cs (cs_id_update, cs_id_adherent, cs_id_section, cs_nom_modif, cs_date_modif) VALUES ' . $req . ' 
                                ON DUPLICATE KEY UPDATE cs_supp = 0, cs_nom_modif = :nom_modif, cs_date_modif = NOW();', ['nom_modif' => $_SESSION['auth']['user']]);
    }

    public function prepReqCss(array $cs, $id_adherent):string {
        $req = '';

        foreach ($cs as $id_section) {
            $req .= "('" . $this->defineUniqCsId($id_adherent, $id_section) . "', " . $id_adherent . "," . $id_section .", :nom_modif, NOW())," ;
        }

        return substr($req, 0, -1);
    }

    public function updateMembreDroits ($id_membre, $id_droit, $section) {
        $update = $this -> bdd -> req('UPDATE t_adherent SET adh_droit = :id_droit, adh_section = :section, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_membre', array('id_membre' => $id_membre, 'id_droit' => $id_droit, 'section' => $section, 'nom_modif' => $_SESSION['auth']['user']));
        return $update->rowCount();
    }

    public function updateMembreDroit ($id_membre, $id_droit) {
        $update = $this -> bdd -> req('UPDATE t_adherent SET adh_droit = :id_droit, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_membre', array('id_membre' => $id_membre, 'id_droit' => $id_droit, 'nom_modif' => $_SESSION['auth']['user']));
        return $update->rowCount();
    }

    public function updateMembreSection ($id_membre, $id_section) {
        $update = $this -> bdd -> req('UPDATE t_adherent SET adh_section = :id_section, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_membre', array('id_membre' => $id_membre, 'id_section' => $id_section, 'nom_modif' => $_SESSION['auth']['user']));
        return $update->rowCount();
    }

    public function resetMembreSection($id_membre) {
        $this -> bdd -> req('UPDATE t_adherent SET adh_section = 0, adh_nom_modif = :nom_modif, adh_date_modif = NOW() WHERE adh_id = :id_membre', array('id_membre' => $id_membre, 'nom_modif' => $_SESSION['auth']['user']));
    }

    public function suppAdherent ($id_adherent){
        $this -> bdd-> req ('UPDATE t_adherent SET adh_supplogiq = 1, adh_nom_modif = :nom_modif WHERE adh_id = :id_adherent', ['nom_modif' => $_SESSION['auth']['user'],'id_adherent'=>$id_adherent]);
    }

    public function suppPreinscription ($id_adherent){
        $this -> bdd-> req ('UPDATE t_adherent SET adh_preinscrit = 0, adh_nom_modif = :nom_modif WHERE adh_id = :id_adherent', ['nom_modif' => $_SESSION['auth']['user'],'id_adherent'=>$id_adherent]);
    }

    public function suppAllCategories($id_ads) {
        $this -> bdd-> req ('UPDATE t_adherent_categorie SET adc_supp = 1, adc_nom_modif = :nom_modif, adc_date_modif = NOW() WHERE adc_id_adh_saison = :id_ads', ['nom_modif' => $_SESSION['auth']['user'], 'id_ads'=>$id_ads]);
    }

    public function suppAllCss($id_adherent) {
        $this -> bdd-> req ('UPDATE t_cs SET cs_supp = 1, cs_nom_modif = :nom_modif, cs_date_modif = NOW() WHERE cs_id_adherent = :id_adherent', ['nom_modif' => $_SESSION['auth']['user'], 'id_adherent'=>$id_adherent]);
    }

    public function getAdherentByNameBirth($nom, $prenom, $birth) {
        return $this -> bdd-> reqSingle('SELECT adh_id as id_adherent FROM t_adherent WHERE adh_nom = :nom AND adh_prenom = :prenom AND adh_birth = :birth',['nom' => $nom, 'prenom' => $prenom, 'birth' => $birth]);
    }

    public function getAdherent($id_adherent) {
        return $this -> bdd-> reqSingle ('SELECT  adh_id as id_adherent FROM t_adherent WHERE adh_id = :id_adherent',array('id_adherent' => $id_adherent));
    }

    public function getPreinscription() {
        return $this -> bdd-> reqMulti ('SELECT  adh_id as id_adherent FROM t_adherent WHERE adh_preinscrit = 1', [],['result' => 'string']);
    }

    public function getAdherents(string $ids_adherent, $params = []): array {
        return $this->bdd->reqIn ('SELECT adh_id as id_adherent, adh_nom as nom, adh_prenom as prenom, adh_nationalite as nationalite , adh_birth as date_birth, adh_numb as numb , adh_rue as rue, adh_cp as cp, adh_ville as ville, adh_numb2 as numb2, adh_rue2 as rue2, adh_cp2 as cp2, adh_ville2 as ville2, adh_mail as mail, adh_mail_mere as mail_mere, adh_mail_pere as mail_pere, adh_tel as tel, adh_gsm as gsm, adh_gsm_pere as gsm_pere, adh_gsm_mere as gsm_mere, adh_inscrit as inscrit, adh_preinscrit as preinscrit FROM t_adherent
                                          WHERE adh_id IN ('.$ids_adherent.') ORDER BY adh_nom', $params);
    }

    public function getAdherentSaison(string $ids_ads, $params = []): array {
        return $this->bdd->reqIn('SELECT adh_id as id_adherent, adh_nom as nom, adh_prenom as prenom, adh_nationalite as nationalite , adh_birth as date_birth, adh_numb as numb_1 , adh_rue as rue_1, adh_cp as cp_1, adh_ville as ville_1, adh_numb2 as numb_2, adh_rue2 as rue_2, adh_cp2 as cp_2, adh_ville2 as ville_2, adh_mail as mail, adh_mail_mere as mail_mere, adh_mail_pere as mail_pere, adh_tel as tel, adh_gsm as gsm, adh_gsm_pere as gsm_pere, adh_gsm_mere as gsm_mere, ads_certif as certif, ads_date_certif as date_certif, ads_cotisation as cotisation, ads_id_cotisation as id_cotisation, ads_date_cotisation as date_cotisation, ads_montant_cotisation as montant, ads_id_licence as id_licence, ads_licence as licence, ads_date_licence as date_licence, ads_numb_licence as numb_licence, adh_inscrit as inscrit, adh_preinscrit as preinscrit , ads_id as id_ads FROM t_adherent_saison
                                        INNER JOIN t_adherent ON ads_id_adherent = adh_id
                                        WHERE ads_id IN ('.$ids_ads.') ORDER BY adh_nom', $params);
    }

    public function getIdSaisonByParams(string $id_saison, $id_section, $statut) {
        return $this->bdd->reqMulti('SELECT DISTINCT ads_id as id_ads FROM t_adherent_saison 
                                            LEFT JOIN t_adherent ON adh_id = ads_id_adherent
                                            LEFT JOIN t_adherent_categorie ON ads_id = adc_id_adh_saison
                                            WHERE ads_id_saison = :id_saison'.$id_section.$statut, ['id_saison' => $id_saison], ['result' => 'string']);
    }

    public function getAdherentBySaison($id_ads) {
        return $this->bdd->reqSingle('SELECT adh_id as id_adherent, adh_nom as nom, adh_prenom prenom, adh_birth as date_birth, adh_civilite as civilite, adh_nationalite as nationalite,adh_numb as numb, adh_rue as rue, adh_cp as cp, adh_ville as ville, adh_numb2 as numb2, adh_rue2 as rue2, adh_cp2 as cp2,adh_ville2 as ville2 , adh_tel as tel,adh_gsm as gsm,adh_gsm_mere as gsm_mere,adh_gsm_pere as gsm_pere,adh_mail as mail,adh_mail_mere as mail_mere,adh_mail_pere as mail_pere, ads_id, ads_id_saison as id_saison, ads_licence as licence, ads_id_licence as id_licence, ads_numb_licence as numb_licence, ads_date_licence as date_licence, ads_certif as certif ,ads_date_certif as date_certif, ads_montant_cotisation as montant, ads_id_cotisation as id_cotisation, ads_date_cotisation as date_cotisation, ads_cotisation as cotisation FROM t_adherent_saison
                                             INNER JOIN t_adherent ON ads_id_adherent = adh_id AND ads_id_saison = :id_ads
                                             WHERE ads_id = :id_ads', ['id_ads' => $id_ads]);
    }

    public function getAdherentsBySaison($id_saison, $id_section) {
        $section = (isset(Section::ID_TO_NAME[$id_section]))? ' AND adc_id_section = ' . $id_section : '';

        return $this -> bdd->reqMulti('SELECT DISTINCT ads_id FROM t_adherent_saison 
                                             LEFT JOIN t_adherent_categorie ON adc_id_adh_saison = ads_id
                                             WHERE ads_id_saison = :id_saison' . $section , ['id_saison' => $id_saison], ['result' => 'string']);
    }

    public function getSaisonsFromAdherent($id_adherent) {
        $saisons = $this -> bdd-> reqMulti('SELECT ads_id_saison as idSaison, sai_saison as saison FROM t_adherent_saison 
                                                   INNER JOIN t_saison ON sai_ID = ads_id_saison
                                                   WHERE ads_id_adherent = :id_adherent ORDER BY sai_saison DESC ',['id_adherent' => $id_adherent]);
        return $this->arrayIdSaisonToSaison($saisons);
    }

    public function getAdherentIdsCategorie($id_ads) {
        return $this -> bdd-> reqMulti('SELECT adc_id_section as id_section, adc_id_fonction as id_fonction, adc_id_categorie as id_categorie, adc_supp  FROM t_adherent_categorie WHERE adc_id_adh_saison = :id_ads',['id_ads' => $id_ads]);
    }

    public function getAdherentIdsCs ($id_adherent) {
        return $this -> bdd-> reqMulti('SELECT cs_id_section as id_section, cs_supp FROM t_cs WHERE cs_id_adherent = :id_adherent', ['id_adherent' => $id_adherent]);
    }

    public function getId_ads($id_adherent, $id_saison) {
        $id_ads = $this -> bdd-> reqSingle('SELECT ads_id FROM t_adherent_saison WHERE ads_id_adherent = :id_adh AND ads_id_saison = :id_saison', ['id_adh' => $id_adherent, 'id_saison' => $id_saison]);
        return $id_ads['ads_id'];
    }

    public function getSaisonByAdherent(){
        return $this->bdd->reqMulti('SELECT sai_ID, sai_saison FROM t_adherent_saison
                                       INNER JOIN t_saison ON sai_ID = ads_id_saison
                                       WHERE ads_supp = 0 GROUP BY sai_ID ORDER BY sai_ID DESC');
    }

    public function getMembres() {
        return $this -> bdd-> reqMulti('SELECT adh_id as id_membre, adh_nom as nom, adh_prenom as prenom, adh_droit as droit, adh_section as section FROM t_adherent WHERE adh_droit != 0 ORDER BY adh_nom');
    }

    public function getMembreSection($id_membre) {
        $sections = $this -> bdd-> reqSingle('SELECT adh_section as sections FROM t_adherent WHERE adh_id = :id_membre', ['id_membre' => $id_membre]);
        return $sections['sections'];
    }

    public function rechercheAdherents($search) {
        return $this -> bdd-> reqMulti("SELECT adh_id as id_adherent, adh_nom as nom, adh_prenom as prenom FROM t_adherent WHERE adh_supplogiq = 0 AND CONCAT(adh_nom,' ',adh_prenom) LIKE UPPER('".$search."%')");
    }

    public function rechercheUsers($search) {
        return $this -> bdd-> reqMulti("SELECT adh_id as id_adherent, adh_nom as nom, adh_prenom as prenom FROM t_adherent WHERE adh_supplogiq = 0 AND adh_droit = " . Droit::USER . " AND CONCAT(adh_nom,' ',adh_prenom) LIKE UPPER('".$search."%')");
    }

    public function getAdherentCategories($id_adherent_saison) {
        return $this -> bdd->reqMulti('SELECT DISTINCT adc_id_fonction as id_fonction, adc_id_section as id_section, adc_id_categorie as id_categorie, cat_categorie as categorie FROM t_adherent_categorie 
                                         INNER JOIN t_categorie ON cat_id = adc_id_categorie
                                         WHERE adc_id_adh_saison = :id_ads AND adc_supp = 0 ORDER BY adc_id_section, adc_id_fonction', ['id_ads'=>$id_adherent_saison]);
    }

    public function getAdherentCs($id_adherent) {
        return $this -> bdd->reqMulti('SELECT cs_id_section as id_section FROM t_cs WHERE cs_id_adherent = :id_adherent AND cs_supp = 0 ORDER BY cs_id_section',['id_adherent'=>$id_adherent]);
    }

    public function getAdherentIdCat($id_ads) {
        return $this -> bdd-> reqMulti('SELECT adc_id_section, adc_id_fonction, adc_id_categorie, adc_supp FROM t_adherent_categorie WHERE adc_id_adh_saison = :id_ads', array('id_ads' => $id_ads));
    }

    public function getAdherentPbCotisation($id_section){
        $id_section = !is_numeric($id_section)? '1,2,3' : $id_section;
        return $this -> bdd-> reqMulti('SELECT DISTINCT adh_id, ads_id, adh_nom, adh_prenom, ads_montant_cotisation, ads_id_cotisation FROM t_adherent_saison
                                           INNER JOIN t_adherent ON adh_id = ads_id_adherent 
                                           INNER JOIN t_saison ON sai_id = ads_id_saison AND sai_active = 1
                                           INNER JOIN t_adherent_categorie ON ads_id = adc_id_adh_saison
                                           WHERE  ads_cotisation = 0 AND adh_supplogiq = 0 AND ads_supp = 0 AND adc_id_section IN ('.$id_section.') ORDER BY adh_nom');
    }

    public function orderCategories($categories) {
        $array = [];

        foreach ($categories as $category) {
            if(!isset($array[$category['id_section']])) {
                $array[$category['id_section']] = [];
            }

            if(!isset($array[$category['id_section']][$category['id_fonction']])) {
                $array[$category['id_section']][$category['id_fonction']] = [];
            }

            $array[$category['id_section']][$category['id_fonction']][$category['id_categorie']] = $category['categorie'];
        }

        return $array;
    }

    public function defineWhereSection($id_section):string {
        if($id_section == 'all') {
            return '';
        }

        return ' AND adc_id_section = ' . $id_section;
    }

    public function defineUniqCatId($id_ads, $id_section, $id_fonction, $id_categorie) {
        return $id_ads . '_' . $id_section . '_' . $id_fonction . '_' . $id_categorie;
    }

    public function defineUniqCsId($id_adherent, $id_section) {
        return $id_adherent . '_' . $id_section;
    }

    public function setParams(array $adherent):array {
        $adherent['date_birth'] = new DateTime($adherent['date_birth']);
        $adherent['verifMail'] = $this->verifMail($adherent['mail'], $adherent['mail_pere'], $adherent['mail_mere']);
        $adherent['verifTel'] = $this->verifTel($adherent['tel'], $adherent['gsm'], $adherent['gsm_mere'], $adherent['gsm_pere']);
        $adherent['color_divPicto'] = $this->colorDivPicto($adherent['verifMail'], $adherent['verifTel'], $adherent['rue_1'], $adherent['licence'], $adherent['certif'], $adherent['cotisation']);

        return $adherent;
    }

    public function setsParams(array $adherents):array {
        foreach ($adherents as $key => $adherent) {
            $adherents[$key] = $this->setParams($adherent);
        }

        return $adherents;
    }

    public function verifCotisation ($id_cotisation, $montant) {
        if($id_cotisation == Database::M_DISPENCE['id']) {
            return 1;
        }

        if ($montant == Database::COT_ID_TO_LABEL[$id_cotisation]) {
            return 1;
        }

        return 0;
    }

    public function verifTel($tel ,$gsm ,$telMere ,$telPere):bool {
        return !empty($tel) || !empty($gsm) || !empty($telMere) || !empty($telPere);
    }

    public function verifMail($mail, $mailMere, $mailPere):bool {
        return !empty($mail) || !empty($mailMere) || !empty($mailPere);
    }

    public function colorDivPicto(bool $verifMail ,bool $verifTel ,$rue, bool $licence, bool $certif, bool $cotisation):string {
        if(!$verifMail || !$verifTel || $rue == "" || $licence == 0 || $certif == 0 || $cotisation == 0){
            return 'red';
        }

        return 'green';
    }

    //retour les resultats sous form d'array ['value1' => 'value2']
    public function arrayIdSaisonToSaison(array $arraysResult):array{
        $array = [];

        foreach ($arraysResult as $arrayResult) {
            $array[$arrayResult['idSaison']] = $arrayResult['saison'];
        }

        return $array;
    }

    public function arrayIdToName (array $adherents):array {
        $array = [];

        foreach ($adherents as $adherent) {
            $array[$adherent['id_adherent']] = $adherent['nom'].' '.$adherent['prenom'];
        }

        return $array;
    }
}

