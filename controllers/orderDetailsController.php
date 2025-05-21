<?php

namespace app\controllers;

use app\models\entities\OrderDetail;
use app\models\entities\Order;
use app\models\entities\Dish;
use app\models\drivers\ConexDB;

class OrderDetailsController
{
    // Registrar detalles de la orden
    public function saveOrderDetails($orderId, $request)
    {
        // Verificar si la orden existe
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE id = {$orderId}";
        $result = $db->execSQL($sql);
        if ($result->num_rows === 0) {
            return "La orden no existe.";
        }
        
        // Guardar los detalles de la orden
        foreach ($request['orderDetails'] as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->set('idOrder', $orderId);
            $orderDetail->set('idDish', $item['idDish']);
            $orderDetail->set('quantity', $item['quantity']);
            
            // Obtener el precio unitario del plato y calcular el total
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();
            
            $orderDetail->set('price', $dishData['price']);
            $orderDetail->save();
        }

        return "Detalles de la orden registrados correctamente.";
    }

    // Ver detalles de una orden
    public function viewOrderDetails($orderId)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM order_details WHERE idOrder = {$orderId}";
        $result = $db->execSQL($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Modificar los detalles de la orden
    public function updateOrderDetails($orderId, $request)
    {
        $db = new ConexDB();
        foreach ($request['orderDetails'] as $item) {
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();

            $sql = "UPDATE order_details SET quantity = {$item['quantity']}, price = {$dishData['price']} 
                    WHERE idOrder = {$orderId} AND idDish = {$item['idDish']}";
            $db->execSQL($sql);
        }

        return "Detalles de la orden actualizados correctamente.";
    }

    // Eliminar un detalle de orden
    public function deleteOrderDetail($orderId, $detailId)
    {
        $db = new ConexDB();
        $sql = "DELETE FROM order_details WHERE idOrder = {$orderId} AND id = {$detailId}";
        return $db->execSQL($sql) ? "Detalle de la orden eliminado correctamente." : "Error al eliminar el detalle de la orden.";
    }
}
