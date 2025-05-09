<?php

namespace app\models\entities;
use app\models\drivers\ConexDB;

class Category extends Entity
{
    protected $id = null;
    protected $name = "";

    public function all()
    {
        $sql = "select * from categories";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $categories = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $category = new Category();
                $category->set('id', $rowDb['id']);
                $category->set('name', $rowDb['name']);
                array_push($categories, $category);
            }
        }
        $conex->close();
        return $categories;
    }

    public function save()
    {

    }

    public function update()
    {
        
    }

    public function delete()
    {
        
    }
}