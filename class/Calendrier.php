<?php
use Connection\Connection;

class Calendrier
{
    CONST SEND_MAIL_UNABLE = 1;
    CONST SEND_MAIL_DISABLE = 0;

    protected $bdd;

    private $sendMail = 0;

    public function __construct() {
        $this->bdd = Connection::getInstance();
        $this->SendMailInBdd();
    }

    public function SendMailInBdd() {
        $result = $this -> bdd-> reqSingle ('SELECT inf_calendar_mail FROM t_info');
        $this->sendMail = $result['inf_calendar_mail'];
    }

    public function getSendMail(): int {
        return $this->sendMail;
    }

    public function updateSendMail(bool $statut) {
        $this -> bdd-> req ('UPDATE t_info SET inf_calendar_mail = :statut', ['statut' => (int)$statut]);
        $this->sendMail = $statut;
    }
}