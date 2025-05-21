<?php

namespace app\controllers;

require_once __DIR__ . '/../models/entities/order.php';

use app\models\entities\Table;
use app\models\entities\Order;
use app\models\drivers\ConexDB;

class TablesController
{
    public function saveNewTable($request)
    {
        $table = new Table();
        $table->set('name', $request['nameInput']);
        
        return $table->save() ? "Mesa registrada correctamente." : "Error al registrar la mesa.";
    }

    public function deleteTable($id)
    {
        $table = new Table();
        $table->set('id', $id);

        if ($this->isTableInUse($id)) {
            return "La mesa está en uso. No se puede eliminar hasta que todas las órdenes asociadas sean anuladas o completadas.";
        }

        return $table->delete() ? "Mesa eliminada correctamente." : "Error al eliminar la mesa.";
    }

    public function updateTable($id, $name)
    {
        $table = new Table();
        $table->set('id', $id);
        $table->set('name', $name);
        return $table->update() ? "Mesa actualizada correctamente." : "Error al actualizar la mesa.";
    }

    public function queryAllTables()
    {
        $table = new Table();
        return $table->all();
    }

    public function isTableInUse($id)
    {
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE idTable = {$id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $row = $result->fetch_assoc();

        $conex->close();

        return $row['order_count'] > 0;
    }
    
    public function queryTableById($id)
    {
        $table = new Table();
        $table->set('id', $id);
        return $table->find();
    }
}