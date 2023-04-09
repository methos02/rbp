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
    public static function find(int $id):?static {
        $model_datas = (new Builder(static::$table, static::class))->where(['id' => $id])->first();
        return $model_datas ? call_user_func_array(static::class . '::make', ['datas' => $model_datas]) : null;
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
