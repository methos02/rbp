<?php

namespace App\Core\Orm;

class BuilderModel {
    protected static string $table = '';
    public static function where(array $conditions):Builder {
        return (new Builder(static::$table, static::class))->where($conditions);
    }
    public static function limit(int $limit):Builder {
        return (new Builder(static::$table, static::class))->limit($limit);
    }

    public static function create(array $datas):string {
        $model = static::factory();

        $properties = array_keys($datas);
        foreach ($properties as $property) {
            if(!$model->has($property)) return false;
        }

        return (new Builder(static::$table, static::class))->create($datas);
    }
}
