<?php

use App\Core\Connection;

class Section extends Table{
    const NATATION = ['id' => 1,'nom' => 'Natation', 'slug' => 'natation'];
    const WATERPOLO = ['id' => 2,'nom' => 'Water-polo', 'slug' => 'waterpolo'];
    const PLONGEON = ['id' => 3,'nom' => 'Plongeon', 'slug' => 'plongeon'];
    const COMITE = ['id' => 4,'nom' => 'Comité', 'slug' => 'comite'];

    const SECTIONS_ID = [1,2,3,4];

    const BTN_COLOR = [
        self::WATERPOLO['id'] => 'btn-success',
        self::PLONGEON['id'] =>  'btn-info',
        self::NATATION['id'] => 'btn-primary',
        self::COMITE['id'] => 'btn-warning'
    ];

    const GET_SECTIONS = [
        self::NATATION['slug'] => self::NATATION,
        self::WATERPOLO['slug'] => self::WATERPOLO,
        self::PLONGEON['slug'] => self::PLONGEON,
        self::COMITE['slug'] => self::COMITE
    ];

    const ID_TO_SLUG = [
        self::NATATION['id'] => self::NATATION['slug'],
        self::WATERPOLO['id'] => self::WATERPOLO['slug'],
        self::PLONGEON['id'] => self::PLONGEON['slug'],
        self::COMITE['id'] => self::COMITE['slug']
    ];

    const ID_TO_NAME = [
        self::NATATION['id'] => self::NATATION['nom'],
        self::WATERPOLO['id'] => self::WATERPOLO['nom'],
        self::PLONGEON['id'] => self::PLONGEON['nom'],
        self::COMITE['id'] => self::COMITE['nom']
    ];

    const SLUG_TO_NAME = [
        self::NATATION['slug'] => self::NATATION['nom'],
        self::WATERPOLO['slug'] => self::WATERPOLO['nom'],
        self::PLONGEON['slug'] => self::PLONGEON['nom'],
        self::COMITE['slug'] => self::COMITE['nom']
    ];

    const SLUG_TO_ID = [
        self::NATATION['slug'] => self::NATATION['id'],
        self::WATERPOLO['slug'] => self::WATERPOLO['id'],
        self::PLONGEON['slug'] => self::PLONGEON['id'],
        self::COMITE['slug'] => self::COMITE['id']
    ];

    const GET_SECTIONS_SPORTIVE = [
        self::NATATION['id'] => self::NATATION['nom'],
        self::WATERPOLO['id'] => self::WATERPOLO['nom'],
        self::PLONGEON['id'] => self::PLONGEON['nom']
    ];

    public static function get($prop, $section_slug) {
        return self::GET_SECTIONS[$section_slug][$prop] ?? null;
    }

    public static function factory():self {
        return new Section(Connection::getInstance());
    }

    public function getCategorie($id_categorie){
        return $this -> bdd-> reqSingle('SELECT cat_id as id_categorie, cat_categorie as categorie, cat_id_section as id_section, cat_id_fonction as id_fonction FROM t_categorie WHERE cat_id = :id_categorie', ['id_categorie' => $id_categorie]);
    }

    public function getCategories(){
        return $this -> bdd-> reqMulti('SELECT cat_id as id_categorie, cat_categorie as categorie, cat_id_section as id_section, cat_id_fonction as id_fonction FROM t_categorie WHERE cat_supplogiq = 0 ORDER BY cat_id');
    }

    public function getCategorieCa() {
        return $this -> bdd-> reqMulti('SELECT cat_id as id_categorie, cat_categorie as categorie FROM t_categorie WHERE cat_id_section = '.Section::COMITE['id'].' AND cat_supplogiq = 0 ORDER BY cat_id');
    }

    public function getCaMembre() {
        return $this ->bdd-> reqMulti('SELECT adh_nom as nom, adh_prenom as prenom, adc_id_categorie as id_categorie FROM t_adherent_categorie
                                         INNER JOIN t_adherent_saison ON ads_id = adc_id_adh_saison
                                         INNER JOIN t_adherent ON adh_id = ads_id_adherent
                                         WHERE adc_supp = 0 AND adc_id_section = '.Section::COMITE['id'].' ORDER BY adc_id_categorie');
    }

    public function getIdDirigeants($id_section) {
        return $this -> bdd-> reqMulti('SELECT cat_id as id_categorie, cat_categorie as categorie FROM t_categorie WHERE cat_id_section = :id_section AND cat_supplogiq = 0 AND cat_unique = 1 ORDER BY cat_id', ['id_section' => $id_section]);
    }

    public function getDirectionSection($id_section) {
        return $this ->bdd-> reqMulti('SELECT adh_nom as nom, adh_prenom as prenom, adc_id_fonction, adc_id_categorie as id_categorie FROM t_adherent_categorie
                                         INNER JOIN t_adherent_saison ON ads_id = adc_id_adh_saison
                                         INNER JOIN t_adherent ON adh_id = ads_id_adherent
                                         INNER JOIN t_categorie ON cat_id = adc_id_categorie
                                         WHERE adc_supp = 0 AND adc_id_section = :id_section AND cat_unique = 1', ['id_section' => $id_section]);
    }

    public function getId_cats() {
        return $this -> bdd-> reqMulti('SELECT cat_id FROM t_categorie WHERE cat_supplogiq = 0',[], ['result' => 'singleArray']);
    }

    public function getUse_uniq_cat() {
        return $this -> bdd-> reqMulti('SELECT cat_id, cat_id_fonction, cat_id_section FROM t_categorie
                                           INNER JOIN t_adherent_categorie ON cat_id = adc_id_categorie
                                           WHERE cat_supplogiq = 0 AND cat_unique = 1 AND adc_supp = 0');
    }

    public static function getLinksSection($id_actuel = null){
        $btns = '';
        foreach(self::GET_SECTIONS as $section) {
            $btns .= '<div class="col-sm-3 text-center"><a href="#" class="btn btn-default' . ($section['id'] == $id_actuel || ($id_actuel == null && $section['id'] == Section::NATATION['id'])?' ' . self::BTN_COLOR[$section['id']]:'').'" data-div="' . $section['id'] . '" data-color="' . self::BTN_COLOR[$section['id']] . '">'.$section['nom'].'</a></div>';
        }
        return $btns;
    }

    public function getEquipe(){
        $equipes = $this -> bdd->reqMulti("SELECT cat_id, cat_categorie, cat_id_entente, cat_active FROM t_categorie WHERE cat_categorie LIKE 'U%' AND cat_supplogiq =0 AND cat_active=1");

        if(empty($equipes)) {
            return "<p>Le RBP n'a pas engagé d'équipe jeune cette saison.";
        }

        //Ordonner le résultat
        $categorie = '';
        foreach($equipes as $equipe){
            $categorie .= $equipe['cat_categorie'].', ';
        }

        return '<p>Le RBP a engagé cette année '. count($equipes) .' équipes dans les championnats suivant: '.substr($categorie, 0, -2);
    }

    public function orderCatIdNameWP($categories) {
        $array = [];

        foreach ($categories as $category) {
            if($category['id_section'] == Section::WATERPOLO['id'] && strpos($category['id_fonction'], strval(Database::F_SPORTIF['id'])) !== false) {
                $array[$category['categorie']] = $category['id_categorie'];
            }
        }

        return $array;
    }

    public function orderDirigeant($categories, $users) {
        $dirigeant = "";

        foreach ($categories as $categorie) {
            $i = 0;

            foreach ($users as $user) {
                if($user['id_categorie'] == $categorie['id_categorie']) {
                    $dirigeant .= '<li>'.$categorie['categorie'].' :'.$user['nom'].' '.$user['prenom'].'</li>';
                    $i = 1;
                }
            }

            if($i == 0) {
                $dirigeant .= '<li>'.$categorie['categorie'].' : Poste vacant.</li>';
            }
        }

        return '<ul>'.$dirigeant.'</ul>';
    }
}
