<?php

namespace App\Models;

use App\Core\Orm\BuilderModel;

class Model extends BuilderModel {
    protected static string $table = '';
    protected static string $prefix = '';
    public static function factory():static {
        return new static();
    }

    /** @noinspection PhpUnused */
    public static function make(array $datas):static {
        $model = static::factory();

        $properties = array_keys($datas);
        foreach ($properties as $property) {
            $model->set($property, $datas[$property]);
        }

        return $model;
    }
    public function has(string $property): bool {
        return property_exists($this, $property);
    }
    public function set(string $property, $value):static {
        if($this->has($property)) { $this->$property = $value; }
        return $this;
    }
    public function get(string $property):?string {
        $property_name = static::$prefix . $property;
        return $this->has($property_name)? $this->$property_name : null;
    }
}
