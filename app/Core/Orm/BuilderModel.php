<?php

namespace App\Core\Orm;

class BuilderModel {
    protected static string $table = '';
    public static function limit(int $limit):Builder {
        $builder = new Builder(static::$table, static::class);
        return $builder->limit($limit);
    }
}
