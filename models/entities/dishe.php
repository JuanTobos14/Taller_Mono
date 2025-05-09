<?php

namespace app\models\entities;
use app\models\drivers\ConexDB;

class Dishe extends Entity
{
    protected $id = null;
    protected $description = "";
    protected $price = null;
    protected $idCategory = null;


    public function all()
    {
        $sql = "select * from dishes";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $dishes = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $dishe = new Dishe();
                $dishe->set('id', $rowDb['id']);
                $dishe->set('description', $rowDb['description']);
                $dishe->set('price', $rowDb['price']);
                $dishe->set('idCategory', $rowDb['idCategory']);
                array_push($dishes, $dishe);
            }
        }
        $conex->close();
        return $dishes;
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