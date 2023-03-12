<?php

namespace App\Core\Orm;

use App\Core\Connection;
use PDO;

class Builder {
    private static $bdd;
    private ?int $limit;

    public function __construct(private readonly string $table, private string $model ) {}

    public static function getInstance($fresh = false) {
        if(is_null(self::$bdd)){
            self::$bdd = new Connection('mysql:host='.DB_HOST.';' . (!$fresh ? 'dbname='.DB_NAME : ''),DB_USERNAME,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            self::$bdd->query("SET NAMES UTF8");
        }

        return self::$bdd;
    }
    
    public function limit($limit):Builder {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit():string {
        return $this->limit !== null ? ' LIMIT ' .$this->limit : '';
    }
    
    public function get():array {
        $statement = self::getInstance()->prepare($this->generateSelect());
        $statement->execute();
        $models_datas = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($model_datas) => call_user_func_array($this->model . '::make', ['datas' => $model_datas]), $models_datas);
    }

    private function generateSelect():string {
        return "SELECT * FROM $this->table" . $this->getLimit();
    }
    
}
