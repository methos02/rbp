<?php

use App\Core\Connection;

class Calendrier extends Table
{
    CONST SEND_MAIL_UNABLE = 1;
    CONST SEND_MAIL_DISABLE = 0;

    private int $sendMail = 0;

    public static function factory():self {
        return new Calendrier(Connection::getInstance());
    }

    public function getSendMail(): int {
        return $this->sendMail;
    }

    public function updateSendMail(bool $statut): void {
        $this->bdd->req('UPDATE t_info SET inf_calendar_mail = :statut WHERE inf_calendar_mail != :statut', ['statut' => (int)$statut]);
        $this->sendMail = $statut;
    }
}
