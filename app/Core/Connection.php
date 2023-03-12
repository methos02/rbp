<?php
namespace App\Core;

use PDO;
use PDOStatement;

class Connection extends PDO {

    private static $_instance;
    const FRESH = true;

    public static function getInstance($fresh = false):self{
        if(is_null(self::$_instance)){
            self::$_instance = new Connection('mysql:host='.DB_HOST.';' . (!$fresh ? 'dbname='.DB_NAME : ''),DB_USERNAME,DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            self::$_instance->query("SET NAMES UTF8");
        }

        return self::$_instance;
    }

    public function reqMulti(string $request, array $paramReq = [], array $param = []) {
        $result = $this->req($request, $paramReq)->fetchAll(PDO::FETCH_ASSOC);

        if(isset($param['result']) && $param['result'] == 'singleArray') {
            return $this->singleArray($result);
        }

        if(isset($param['result']) && $param['result'] == 'string') {
            return $this->stringResult($result);
        }

        return $result;
    }

    public function reqSingle(string $request, array $param = []) {
        return $this->req($request, $param)->fetch(PDO::FETCH_ASSOC);
    }

    public function reqIn(string $request, $params = []) {
        $req = $this->req($request);

        if(isset($params['multi']) && $params['multi']) {
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function req($request, $param = []) {
        if(!empty($param)){
            $req = $this->prepare($request);
            $req->execute($param);
            return $req;
        }

        return $this->query($request);
    }

    public function last(){
       return $this -> lastInsertId();
    }

    //Regrouper les résultats quand un seul array
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
