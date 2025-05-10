<?php

namespace app\models\entities;
use app\models\drivers\ConexDB;

class Table extends Entity
{
    protected $id = null;
    protected $name = "";

    public function all()
    {
        $sql = "select * from restaurant_tables";
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
        $sql = "DELETE FROM restaurant_tables WHERE id = {$this->id}";
        $conex = new ConexDB();
        $resultDB = $conex->execSQL($sql);
        $conex->close();
        return $resultDB;     
    }
}