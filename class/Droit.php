<?php

use App\Core\Connection;

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

    public static function factory(): Droit {
        return new Droit(Connection::getInstance());
    }
}
