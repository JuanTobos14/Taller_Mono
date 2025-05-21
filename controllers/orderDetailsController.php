<?php

namespace app\controllers;

include_once __DIR__ . '/../models/drivers/conexDB.php';

use app\models\entities\OrderDetail;
use app\models\entities\Order;
use app\models\entities\Dish;
use app\models\drivers\ConexDB;

class OrderDetailsController
{
    public function saveOrderDetails($orderId, $request)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE id = {$orderId}";
        $result = $db->execSQL($sql);
        if ($result->num_rows === 0) {
            return "La orden no existe.";
        }
    
        $totalOrder = 0;

        foreach ($request['orderDetails'] as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->set('idOrder', $orderId);
            $orderDetail->set('idDish', $item['idDish']);
            $orderDetail->set('quantity', $item['quantity']);
            
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();
            $price = $dishData['price'];
            $subtotal = $price * $item['quantity'];
            
            $orderDetail->set('price', $price);
            $orderDetail->save();
        
            $totalOrder += $subtotal;
        }
    
        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);
    
        return "Detalles de la orden registrados correctamente.";
    }

    public function viewOrderDetails($orderId)
    {
        $db = new ConexDB();
        $sql = "SELECT od.*, d.description AS dishName, d.price AS dishPrice 
        FROM order_details od 
        JOIN dishes d ON od.idDish = d.id WHERE od.idOrder = {$orderId}";
        $result = $db->execSQL($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrderDetails($orderId, $request)
    {
        $db = new ConexDB();
        $totalOrder = 0;

        foreach ($request['orderDetails'] as $item) {
            $sql = "SELECT price FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishData = $result->fetch_assoc();

            $sql = "UPDATE order_details 
            SET quantity = {$item['quantity']}, price = {$dishData['price']} 
            WHERE idOrder = {$orderId} AND idDish = {$item['idDish']}";
            $db->execSQL($sql);

            $subtotal = $dishData['price'] * $item['quantity'];
            $totalOrder += $subtotal;
        }

        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);

        return "Detalles de la orden actualizados correctamente.";
    }

    public function deleteOrderDetail($orderId, $detailId)
    {
        $db = new ConexDB();

        $sql = "SELECT price, quantity FROM order_details WHERE idOrder = {$orderId} AND id = {$detailId}";
        $result = $db->execSQL($sql);
        $row = $result->fetch_assoc();

        $subtotal = $row['price'] * $row['quantity'];

        $sql = "DELETE FROM order_details WHERE idOrder = {$orderId} AND id = {$detailId}";
        $db->execSQL($sql);

        $sql = "SELECT SUM(price * quantity) AS total FROM order_details WHERE idOrder = {$orderId}";
        $result = $db->execSQL($sql);
        $row = $result->fetch_assoc();
        $totalOrder = $row['total'];

        $sql = "UPDATE orders SET total = {$totalOrder} WHERE id = {$orderId}";
        $db->execSQL($sql);

        return "Detalle de la orden eliminado correctamente.";
    }
}
