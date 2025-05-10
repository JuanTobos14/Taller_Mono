<?php

namespace app\controllers;
use app\models\entities\Table;
use app\models\drivers\ConexDB;

class TablesController
{
   public function queryAllTables()
    {
        $table = new Table();
        return $table->all();
    }

    public function saveNewTable($request)
    {
        $table = new Table();
        $table->set('name', $request['nameInput']);
        return $table->save();
    }

    public function updateTable($request)
    {
        $table = new Table();
        $table->set('id', $request['idInput']);
        $table->set('name', $request['nameInput']);
        return $table->update();
    }

    public function deleteTable($id)
    {
         $table = new Table();
        $table->set('id', $id);
        $conex = new ConexDB();
        $sqlCheck = "SELECT * FROM orders WHERE idTable = {$id}";
        $resultCheck = $conex->execSQL($sqlCheck);

        if ($resultCheck->num_rows > 0) {
          $conex->close();
          return "No se puede eliminar la mesa porque está asociada a una o más órdenes.";
        }

        $deleted = $table->delete();
        $conex->close();
        return $deleted ? "Mesa eliminada correctamente." : "Error al eliminar la mesa.";
    }
}