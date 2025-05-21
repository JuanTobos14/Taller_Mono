<?php

namespace app\controllers;

require_once __DIR__ . '/../models/entities/order.php';

use app\models\entities\Table;
use app\models\entities\Order;
use app\models\drivers\ConexDB;

class TablesController
{
    // Registrar una nueva mesa
    public function saveNewTable($request)
    {
        $table = new Table();
        $table->set('name', $request['nameInput']);
        
        // Guardar la mesa y devolver un mensaje apropiado
        return $table->save() ? "Mesa registrada correctamente." : "Error al registrar la mesa.";
    }

    // Eliminar mesa (modificado)
    public function deleteTable($id)
    {
        $table = new Table();
        $table->set('id', $id);

        // Verificar si la mesa está en uso
        if ($this->isTableInUse($id)) {
            return "La mesa está en uso. No se puede eliminar hasta que todas las órdenes asociadas sean anuladas o completadas.";
        }

        // Proceder con la eliminación si no está en uso
        return $table->delete() ? "Mesa eliminada correctamente." : "Error al eliminar la mesa.";
    }

    // Modificar una mesa
    public function updateTable($id, $name)
    {
        $table = new Table();
        $table->set('id', $id);
        $table->set('name', $name);
        return $table->update() ? "Mesa actualizada correctamente." : "Error al actualizar la mesa.";
    }

    // Listar todas las mesas
    public function queryAllTables()
    {
        $table = new Table();
        return $table->all();
    }

    // Consultar si una mesa está asociada a órdenes (para eliminar)
    public function isTableInUse($id)
    {
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE idTable = {$id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $row = $result->fetch_assoc();

        $conex->close();

        return $row['order_count'] > 0;  // Si hay órdenes, la mesa está en uso
    }
    
    // Consultar mesa por ID
    public function queryTableById($id)
    {
        $table = new Table();
        $table->set('id', $id);
        return $table->find();  // Asumimos que `find()` devuelve la mesa por ID
    }
}