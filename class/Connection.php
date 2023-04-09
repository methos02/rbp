<?php
namespace Connection;
use PDO;

class Connection extends PDO{

    private static $_instance;

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Connection('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USERNAME,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            self::$_instance->query("SET NAMES UTF8");
        }

        return self::$_instance;
    }

    public function reqMulti(string $requet, array $paramReq = [], array $param = []) {
        $result = $this->req($requet, $paramReq)->fetchAll(PDO::FETCH_ASSOC);

        if(isset($param['result']) && $param['result'] == 'singleArray') {
            return $this->singleArray($result);
        }

        if(isset($param['result']) && $param['result'] == 'string') {
            return $this->stringResult($result);
        }

        return $result;
    }

    public function reqSingle(string $requet, array $param = []) {
        return $this->req($requet, $param)->fetch(PDO::FETCH_ASSOC);
    }

    public function reqIn(string $requet, $params = []) {
        $req = $this->req($requet);

        if(isset($params['multi']) && $params['multi'] == true) {
            return $req -> fetchAll(PDO::FETCH_ASSOC);
        }

        return $req -> fetch(PDO::FETCH_ASSOC);
    }

    public function req($requet, $param = []){
        if(!empty($param)){
            $req = $this ->prepare($requet);
            $req -> execute($param);
            return $req;
        }

        return $this ->query($requet);
    }

    public function last(){
       return $this -> lastInsertId();
    }

    //Regrouper les résultats quand une seul array
    public function singleArray(array $results):array {
        $array = [];

        foreach ($results as $result) {
            $array[] = implode("", $result);
        }

        return $array;
    }

    //implode les résultats
    public function stringResult(array $results):string {
        return implode(',', $this->singleArray($results));
    }
}