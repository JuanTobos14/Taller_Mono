<?php
namespace app\models\entities;
use app\models\drivers\ConexDB;

class Table extends Entity
{
    protected $id = null;
    protected $name = "";

    public function all()
    {
        $sql = "SELECT * FROM restaurant_tables";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $tables = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $table = new Table();
                $table->set('id', $rowDb['id']);
                $table->set('name', $rowDb['name']);
                array_push($tables, $table);
            }
        }
        $conex->close();
        return $tables;
    }

    public function save()
    {
        $sql = "INSERT INTO restaurant_tables (name) VALUES ('{$this->name}')";
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function update()
    {
        $sql = "UPDATE restaurant_tables SET name='{$this->name}' WHERE id={$this->id}";
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function delete()
    {
        // Verificar si la mesa está asociada a alguna orden
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE idTable = {$this->id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $row = $result->fetch_assoc();

        if ($row['order_count'] > 0) {
            $conex->close();
            return false; // No se puede eliminar si está asociada a órdenes
        }

        $sql = "DELETE FROM restaurant_tables WHERE id = {$this->id}";
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;
    }

    public function find()
    {
        $sql = "SELECT * FROM restaurant_tables WHERE id = {$this->id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->set('id', $row['id']);
            $this->set('name', $row['name']);
            $conex->close();
            return $this;
        }
    
        $conex->close();
        return null;
    }
}