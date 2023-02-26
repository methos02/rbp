<?php
use Connection\Connection;
class Droit extends Table {
    CONST USER = 0;
    CONST REDAC = 1;
    CONST RESP = 2;
    CONST ADMIN = 3;

    CONST DROITS = [
        self::USER => ['label' => 'Utilisateur'],
        self::REDAC => ['label' => 'Rédacteur'],
        self::RESP => ['label' => 'Responsable'],
        self::ADMIN => ['label' => 'Administrateur']
    ];

    CONST RESP_ID_TO_DROIT = [
        self::USER => self::DROITS[self::USER]['label'],
        self::REDAC => self::DROITS[self::REDAC]['label'],
        self::RESP => self::DROITS[self::RESP]['label'],
        self::ADMIN => self::DROITS[self::ADMIN]['label']
    ];

    public static function factory() {
        $dbb = Connection::getInstance();
        $instance = new Droit($dbb);

        return $instance;
    }

    public function getLog(){
        if (isset($_SESSION['auth']['mail'], $_SESSION['auth']['cle'])) {

            $user = $this->bdd->reqSingle('SELECT adh_id, adh_nom, adh_prenom, adh_section, adh_droit FROM t_adherent WHERE adh_mail=:mail AND adh_cle=:cle',
                ['mail' => $_SESSION['auth']['mail'], 'cle' => $_SESSION['auth']['cle']]);

            if (!empty($user)) {
                $_SESSION['auth']['user'] = $user['adh_nom'] . ' ' . $user['adh_prenom'];
                $_SESSION['auth']['ID'] = $user['adh_id'];
                $_SESSION['auth']['section'] = $user['adh_section'];

                return['droit' => $user['adh_droit'], 'section' => $user['adh_section']];
            }
        }

        return ['droit'=> 0, 'section' => 0];
    }
}