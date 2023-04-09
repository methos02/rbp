<?php
use Connection\Connection;
//use Sendinblue\Mailin;

Class Mail {
    PRIVATE $mail;
    PRIVATE $bdd;
    CONST MAIL_EXP = 'support@rbp.be';
    CONST MAIL_NOM = 'Royale Brussels Poseidon';

    CONST ID_PRESIDENT = 1;
    CONST ID_SECRETAIRE = 2;
    CONST ID_TRESORIER = 3;
    CONST ID_NATATION = 4;
    CONST ID_WATERPOLO = 5;
    CONST ID_PLONGEON= 6;

    CONST PRESIDENT = 'Président';
    CONST SECRETAIRE = 'Secrétaire';
    CONST TRESORIER = 'Trésorier';
    CONST NATATION = 'Natation';
    CONST WATERPOLO = 'Water-polo';
    CONST PLONGEON = 'Plongeon';

    CONST MAIL_PRESIDENT = 'president@rbp.be';
    CONST MAIL_SECRETAIRE = 'secretaire@rbp.be';
    CONST MAIL_TRESORIER = 'tresorier@rbp.be';
    CONST MAIL_NATATION = 'natation@rbp.be';
    CONST MAIL_WATERPOLO = 'waterpolo@rbp.be';
    CONST MAIL_PLONGEON = 'plongeon@rbp.be';

    CONST TEMPLATE_NEWS = 2;
    CONST TEMPLATE_NEW_MDP = 3;
    CONST TEMPLATE_INSCRIPTION = 4;

    CONST ARR_CONTACT_ID_TO_NAME = [
        self::ID_SECRETAIRE => self::SECRETAIRE,
        self::ID_NATATION => self::NATATION,
        self::ID_WATERPOLO => self::WATERPOLO,
        self::ID_PLONGEON => self::PLONGEON
    ];

    CONST ARR_CONTACT_ID_TO_MAIL = [
        self::ID_PRESIDENT => self::MAIL_PRESIDENT,
        self::ID_SECRETAIRE => self::MAIL_SECRETAIRE,
        self::ID_TRESORIER => self::MAIL_TRESORIER,
        self::ID_NATATION => self::MAIL_NATATION,
        self::ID_WATERPOLO => self::MAIL_WATERPOLO,
        self::ID_PLONGEON => self::MAIL_PLONGEON
    ];

    public function __construct(Connection $bdd){
//        $this -> mail = new Mailin("https://api.sendinblue.com/v2.0", "NBghAmYPyGDFZsH7");
        $this -> bdd = $bdd;
    }

    public static function factory(){
        $dbb = Connection::getInstance();
        $instance = new Mail($dbb);

        return $instance;
    }

    public function addMailNews ($mail, $cle) {
        $this -> bdd -> req('INSERT INTO t_news_mail (nel_mail, nel_cle) VALUES (:mail, :cle)', array('mail' => $mail, 'cle' => $cle));
    }

    public function updateMailNews ($mail, $statut) {
        $this -> bdd-> req ('UPDATE t_news_mail SET nel_supp = :statut WHERE nel_mail = :mail', array('statut' => $statut, 'mail' => $mail));
    }

    public function suppMailNews ($cle) {
        $supp = $this -> bdd-> req ('UPDATE t_news_mail SET nel_supp = 1 WHERE nel_cle = :cle', array('cle' => $cle));
        return $supp -> rowCount();
    }

    public function getMailNews( $mail ) {
        return $this -> bdd-> reqSingle('SELECT nel_id as id_mail, nel_mail as mail, nel_supp as statut FROM t_news_mail WHERE nel_mail = :mail',array('mail' => $mail));
    }

    public function getMailsNews() {
        return $this->bdd->reqMulti('SELECT nel_mail as mail, nel_cle as cle FROM t_news_mail WHERE nel_supp = 0');
    }

    public function sendMailNews($titre) {
        $mails = $this->getMailsNews();

        foreach ($mails as $mail) {
            $data = array( "id" => Mail::TEMPLATE_NEWS,
                "to" => Mail::MAIL_EXP,
                "bcc" => $mail['mail'],
                "attr" => array("NOM_NEWS"=> $titre, "URL" => URL_SITE_MAIL, "CLE" => $mail['cle']),
                "headers" => array("Content-Type"=> "text/html;charset=iso-8859-1", "X-param1"=> "value1", "X-param2"=> "value2", "X-Mailin-custom"=>"my custom value","X-Mailin-tag"=>"my tag value")
            );

            $this -> mail ->send_transactional_template($data);
        }
    }

    public function mailValidation($mail){
        $sujet = "Validation inscription";

        $message = '<p>Bonjour,</p>'
            . '<p>Pour valider votre inscription, veuillez cliquer sur le lien suivant :</p>'
            . '<p><a href="'.URL_SITE.'t-compte_activation/mail-'.$mail.'"> Cliquez ici pour valider l\'inscription </a></p>'
            . ' '
            . '<p>Dans le cas contraire, veuillez avertir un responsable du club.</p>'
            . ' '
            . '<p>Bien à vous</p>'
            . '<p>L\'équipe du site du R.B.P</p>'
            . ' '
            . '<p>---------</p>'
            . '<p>Ceci est un mail automatique, Merci de ne pas y répondre.</p>';


        $dataMail = array(
            'to' => array($mail => $mail),
            'from' => array(Mail::MAIL_EXP,Mail::MAIL_NOM),
            'subject' => $sujet,
            'html' => $message);

        $this->mail->send_email($dataMail);

    }

    public function mailErreurScraperWP($contenu){
        $sujet = "Erreur Scraper WP";

        $dataMail = array(
            'to' => array('leonfrederic@gmx.fr' => 'leonfrederic@gmx.fr'),
            'from' => array(Mail::MAIL_EXP,Mail::MAIL_NOM),
            'subject' => $sujet,
            'html' => $contenu);

        $this->mail->send_email($dataMail);

    }

    public function mailNewMdp($mail, $id_user, $cle){
        $sujet = "Réinitialisation de mot de passe";

        $data = array( "id" => Mail::TEMPLATE_NEW_MDP,
            "to" => $mail,
            "attr" => array("NOM_NEWS"=> $sujet, "URL" => URL_SITE_MAIL, "CLE" => $cle, "ID_USER" => $id_user),
            "headers" => array("Content-Type"=> "text/html;charset=iso-8859-1", "X-param1"=> "value1", "X-param2"=> "value2", "X-Mailin-custom"=>"my custom value","X-Mailin-tag"=>"my tag value")
        );

        $this->mail->send_transactional_template($data);
    }

    public function mailContact($mail_destinataire, $mail_envoie, $message, $sujet){

        $dataMail = array(
            'to' => array($mail_destinataire => $mail_destinataire),
            'from' => array($mail_envoie,$mail_envoie),
            'subject' => $sujet,
            'html' => htmlspecialchars($message));

        $this->mail->send_email($dataMail);
    }
}
