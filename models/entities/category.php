<?php

namespace app\models\entities;
use app\models\drivers\ConexDB;
use app\models\entities\Dishe;

class Category extends Entity
{
    protected $id = null;
    protected $name = "";

    public function all()
    {
        $sql = "SELECT * FROM categories";
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
        $sql = "INSERT INTO categories (name) VALUES ('".$this->name."')";
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function update()
    {
        $sql = "UPDATE categories SET name='".$this->name."' WHERE id=".$this->id;
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function delete()
    {
        $sql = "SELECT COUNT(*) AS dish_count FROM dishes WHERE idCategory = " . $this->id;
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $row = $result->fetch_assoc();

        if ($row['dish_count'] > 0) {
            $conex->close();
            return false;
        }

        $sql = "DELETE FROM categories WHERE id=" . $this->id;
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function getPlatosAsociados()
    {
        $sql = "SELECT * FROM dishes WHERE idCategory = " . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $dishes = [];
        
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $dishe = new Dishe();
                $dishe->set('id', $rowDb['id']);
                $dishe->set('description', $rowDb['description']);
                $dishe->set('price', $rowDb['price']);
                array_push($dishes, $dishe);
            }
        }
        
        $conex->close();
        return $dishes;
    }
}