<?php
namespace app\models\entities;

include_once '../../models/entities/order_detail.php';

use app\models\drivers\ConexDB;
use Exception;

class Dishe extends Entity 
{
    protected $id = null;
    protected $description = "";
    protected $price = null;
    protected $idCategory = null;

    public function all()
    {
        // Si idCategory está definido, solo se filtra por esa categoría
        if ($this->idCategory !== null) {
            $sql = "SELECT * FROM dishes WHERE idCategory = {$this->idCategory}";
        } else {
            // Si no se pasa idCategory, obtenemos todos los platos
            $sql = "SELECT * FROM dishes";
        }
    
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
        return $dishes;  // Retorna un array de objetos Dishe
    }

    public function save()
    {
        $sql = "INSERT INTO dishes (description, price, idCategory) VALUES ('".$this->description."', '".$this->price."', ".$this->idCategory.")";
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function update()
    {
        $sql = "UPDATE dishes SET description='".$this->description."', price='".$this->price."', idCategory=".$this->idCategory." WHERE id=".$this->id;
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function delete()
    {
        // Verificar si el plato está asociado a alguna orden
        $sql = "SELECT COUNT(*) AS order_count FROM order_details WHERE idDish = " . $this->id;
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $row = $result->fetch_assoc();
    
        if ($row['order_count'] > 0) {
            $conex->close();
            return false; // No se puede eliminar el plato si está asociado a una orden
        }
    
        // Si no está asociado a órdenes, proceder con la eliminación
        $sql = "DELETE FROM dishes WHERE id = " . $this->id;
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }
}
