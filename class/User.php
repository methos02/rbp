<?php
use Connection\Connection;

class User extends Table {
    public static function factory(){
        $dbb = Connection::getInstance();
        $instance = new User($dbb);

        return $instance;
    }

    public function updateMdp ($id_user, $mdp) {
        $this->bdd->req('UPDATE t_adherent SET adh_mdp=:mdp WHERE adh_droit != 0 AND adh_id = :id_user', ['id_user' => $id_user, 'mdp' => $mdp]);
    }

    public function confirmeUser($mail, $cle){
        $this -> bdd->req('UPDATE t_adherent SET adh_cle = :cle WHERE adh_mail=:mail AND adh_droit != '.Droit::USER.' AND adh_mdp IS NOT NULL', ['mail' => $mail, 'cle' => $cle]);
    }

    public function updateUser($mail, $mdp) {
        $this->bdd -> req('UPDATE t_adherent set adh_mdp=:mdp WHERE adh_droit != '.Droit::USER.' AND adh_mail = :mail',['mail'=>$mail, 'mdp' =>$mdp]);
    }

    public function getUserByMail($mail){
        return $rep = $this -> bdd -> reqSingle('SELECT adh_id, adh_mail, adh_cle, adh_droit FROM t_adherent WHERE adh_mail=:mail',['mail'=> $mail]);
    }

    public function connectUser($mail, $mdp){
        return $rep = $this -> bdd -> reqSingle('SELECT adh_mail, adh_cle, adh_droit FROM t_adherent WHERE adh_mail=:mail AND adh_mdp=:mdp',['mail'=> $mail, 'mdp' => $mdp]);
    }

    public function verifUser($mail){
        return $this->bdd ->reqSingle("SELECT adh_cle as cle, adh_id as id_user, adh_droit FROM t_adherent WHERE adh_mail=:adh_mail", ['adh_mail'=>$mail]);
    }

    public function verifUserBySecurity($cle, $id_user){
        return $this->bdd ->reqSingle("SELECT adh_id as id_user FROM t_adherent WHERE adh_id=:id_user AND adh_cle=:cle", compact('cle', 'id_user'));
    }
}