<?php

namespace App\Models;

use App\Core\Connection;
use Table;

class Model extends Table {
    protected string $table = '';
    public static function factory():static {
        return new static(Connection::getInstance());
    }

    public static function create(array $datas):string {
        $model = static::factory();

        $properties = array_keys($datas);
        foreach ($properties as $property) {
            if(!$model->has($property)) return 'error';
        }

        $req = $model->bdd->prepare("INSERT INTO $model->table (". implode(',', $properties).") VALUES (". implode(',', array_map(fn(string $property) => ":$property", $properties)).")");
        $req->execute($datas);

        return 'success';
    }

    public function has(string $property): bool {
        return property_exists($this, $property);
    }
}
