<?php 

namespace app\models\entities;
use app\models\drivers\ConexDB;

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
        $sql = "DELETE FROM categories WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function getPlatosAsociados()
{
    $sql = "SELECT * FROM dishes WHERE category_id = " . $this->id;
    $conex = new ConexDB();
    $resultDb = $conex->execSQL($sql);
    $platos = [];
    
    if ($resultDb->num_rows > 0) {
        while ($rowDb = $resultDb->fetch_assoc()) {
            $plato = new Dishe();
            $plato->set('id', $rowDb['id']);
            $plato->set('name', $rowDb['name']);
            array_push($platos, $plato);
        }
    }
    
    $conex->close();
    return $platos;
}
}
