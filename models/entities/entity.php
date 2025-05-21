<?php

namespace app\models\entities;

abstract class Entity
{
    abstract function all();
    abstract function save();
    abstract function update();
    abstract function delete();

    public function set($prop, $value)
    {
        $this->{$prop} = $value;
    }

    public function get($prop)
    {
        // Cambiar aquí para manejar propiedades de manera flexible.
        // Asegurarse de que se retorne el valor de la propiedad si existe.
        if (property_exists($this, $prop)) {
            return $this->{$prop};
        } else {
            return null; // O puedes manejarlo de alguna otra forma
        }
    }
}
