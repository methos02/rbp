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

    public static function all():array {
        return (new Builder(static::$table, static::class))->get();
    }

    public static function create(array $datas):string {
        $model = static::factory();

        $properties = array_keys($datas);
        foreach ($properties as $property) {
            if(!$model->has($property)) return false;

            $setter = 'set' . ucfirst($property);
            if(method_exists($model,$setter)) $datas[$property] = $model->$setter($datas[$property])->get($property);
        }

        if(method_exists($model, 'default_properties')) { $datas = array_merge($datas, $model->default_properties()); }
        return (new Builder(static::$table, static::class))->create($datas);
    }
}
