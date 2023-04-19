<?php

namespace App\Core\Orm;

use App\Core\Connection;
use App\Core\Request;
use App\Models\Model;
use PDO;

class Builder {
    private static $bdd;
    private ?int $limit = null;
    private int $offset = 0;
    private array $where = [];

    public function __construct(private readonly string $table, private readonly string $model ) {}

    public static function getInstance($fresh = false) {
        if(is_null(self::$bdd)){
            self::$bdd = new Connection('mysql:host='.DB_HOST.';' . (!$fresh ? 'dbname='.DB_NAME : ''),DB_USERNAME,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            self::$bdd->query("SET NAMES UTF8");
        }

        return self::$bdd;
    }
    public function where($conditions):Builder {
        $this->where = array_merge($this->where, $conditions);
        return $this;
    }
    public function getWhere():string {
        if(empty($this->where)) return '';

        $wheres = [];
        foreach ($this->where as $key => $value) { $wheres[] = "$key = :$key"; }

        return ' WHERE ' . implode(' AND ', $wheres);
    }
    public function limit($limit):Builder {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit():string {
        return $this->limit !== null ? ' LIMIT '. $this->limit : '';
    }

    public function paginate(int $limit):array {
        $this->limit = $limit;
        $this->offset = Request::get('page');
        return $this->get();
    }

    public function getOffset():string {
        return $this->offset != 0 ? ' OFFSET '. $this->offset * $this->limit : '';
    }
    public function get():array {
        $statement = self::getInstance()->prepare($this->generateSelect());
        $statement->execute($this->where);
        $models_datas = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($model_datas) => call_user_func_array($this->model . '::make', ['datas' => $model_datas]), $models_datas);
    }

    public function first():?Model {
        $statement = self::getInstance()->prepare($this->generateSelect());
        $statement->execute($this->where);
        $model_datas = $statement->fetch(PDO::FETCH_ASSOC);
        return  $model_datas ? call_user_func_array($this->model . '::make', ['datas' => $model_datas]) : null;
    }

    public function count():int {
        $statement = self::getInstance()->prepare($this->generateSelect('count(*)'));
        $statement->execute($this->where);
        return $statement->fetchColumn();
    }

    private function generateSelect($fields = '*'):string {
        return "SELECT $fields FROM $this->table" . $this->generateEndRequest();
    }

    private function generateEndRequest():string {
        return $this->getWhere().$this->getLimit().$this->getOffset();
    }

    public function create(array $datas):bool {
        $properties = array_keys($datas);
        $req = self::getInstance()->prepare("INSERT INTO ". $this->table ." (". implode(',', $properties).") VALUES (". implode(',', array_map(fn(string $property) => ":$property", $properties)).")");
        return $req->execute($datas);
    }
}
