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

    }

    public function update()
    {
        
    }

    public function delete()
    {
        
    }
}