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
    
        $totalOrder = 0; // Para acumular el total de la orden
    
        // Guardar los detalles de la orden
        foreach ($request['orderDetails'] as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->set('idOrder', $orderId);
            $orderDetail->set('idDish', $item['idDish']);
            $orderDetail->set('quantity', $item['quantity']);
            
            // Obtener el precio unitario del plato y calcular el subtotal
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();
            $price = $dishData['price'];
            $subtotal = $price * $item['quantity'];
            
            // Guardar el precio unitario y el detalle
            $orderDetail->set('price', $price);
            $orderDetail->save();
        
            // Sumar al total de la orden
            $totalOrder += $subtotal;
        }
    
        // Actualizar el total de la orden
        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);
    
        return "Detalles de la orden registrados correctamente.";
    }

    // Ver detalles de una orden
    public function viewOrderDetails($orderId)
    {
        $db = new ConexDB();
        $sql = "SELECT od.*, d.description AS dishName, d.price AS dishPrice 
        FROM order_details od 
        JOIN dishes d ON od.idDish = d.id WHERE od.idOrder = {$orderId}";
        $result = $db->execSQL($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Modificar los detalles de la orden
    public function updateOrderDetails($orderId, $request)
    {
        $db = new ConexDB();
        $totalOrder = 0; // Para recalcular el total de la orden

        foreach ($request['orderDetails'] as $item) {
            // Obtener el precio unitario del plato
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();

            // Actualizar el detalle de la orden
            $sql = "UPDATE order_details 
                    SET quantity = {$item['quantity']}, price = {$dishData['price']} 
                    WHERE idOrder = {$orderId} AND idDish = {$item['idDish']}";
            $db->execSQL($sql);

            // Calcular el subtotal y sumar al total de la orden
            $subtotal = $dishData['price'] * $item['quantity'];
            $totalOrder += $subtotal;
        }

        // Actualizar el total de la orden
        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);

        return "Detalles de la orden actualizados correctamente.";
    }

    // Eliminar un detalle de orden
    public function deleteOrderDetail($orderId, $detailId)
    {
        $db = new ConexDB();

        // Obtener el precio y la cantidad del detalle que se va a eliminar
        $sql = "SELECT price, quantity FROM order_details WHERE idOrder = {$orderId} AND id = {$detailId}";
        $result = $db->execSQL($sql);
        $row = $result->fetch_assoc();

        // Calcular el subtotal que se va a restar
        $subtotal = $row['price'] * $row['quantity'];

        // Eliminar el detalle
        $sql = "DELETE FROM order_details WHERE idOrder = {$orderId} AND id = {$detailId}";
        $db->execSQL($sql);

        // Recalcular el total de la orden
        $sql = "SELECT SUM(price * quantity) AS total FROM order_details WHERE idOrder = {$orderId}";
        $result = $db->execSQL($sql);
        $row = $result->fetch_assoc();
        $totalOrder = $row['total'];

        // Actualizar el total de la orden
        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);

        return "Detalle de la orden eliminado correctamente.";
    }

    public function getOrdersReport($startDate, $endDate)
    {
        $sql = "SELECT o.id, o.dateOrder, o.total, t.name AS tableName 
                FROM orders o 
                JOIN tables t ON o.idTable = t.id 
                WHERE o.dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND o.isCancelled = 0";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $orders = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $order = new Order();
                $order->set('id', $rowDb['id']);
                $order->set('dateOrder', $rowDb['dateOrder']);
                $order->set('total', $rowDb['total']);
                $order->set('tableName', $rowDb['tableName']);
                array_push($orders, $order);
            }
        }
        $conex->close();
        return $orders;
    }

}
