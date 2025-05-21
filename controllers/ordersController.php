<?php

namespace app\controllers;

include_once __DIR__ . '/../models/entities/order_detail.php';
include_once __DIR__ . '/../models/entities/order.php';
include_once __DIR__ . '/../models/drivers/conexDB.php';

use app\models\drivers\ConexDB;
use app\models\entities\Order;
use app\models\entities\OrderDetail;
use app\models\entities\Dishe;
use app\models\entities\Table;

class OrdersController
{
    private function ensureAnularColumnExists()
    {
        $db = new ConexDB();

        $checkSql = "SHOW COLUMNS FROM orders LIKE 'anular'";
        $result = $db->execSQL($checkSql);

        if ($result->num_rows == 0) {
            $alterSql = "ALTER TABLE orders ADD COLUMN anular TINYINT(1) DEFAULT 0";
            $db->execSQL($alterSql);
        }
    }

    public function saveNewOrder($request)
    {
        $order = new Order();
        $order->set('dateOrder', $request['dateOrderInput']);
        $order->set('idTable', $request['idTableInput']);
        
        $total = 0;
        $orderDetails = [];
        foreach ($request['orderDetails'] as $item) {
            $db = new ConexDB();
            $sql = "SELECT * FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishDetails = $result->fetch_assoc();
            
            $priceUnit = $dishDetails['price'];
            $quantity = $item['quantity'];
            $total += $quantity * $priceUnit;
            
            $orderDetail = new OrderDetail();
            $orderDetail->set('idDish', $item['idDish']);
            $orderDetail->set('quantity', $quantity);
            $orderDetail->set('price', $priceUnit);
            $orderDetails[] = $orderDetail;
        }

        $order->set('total', $total);
        
        $orderSaved = $order->save();
        foreach ($orderDetails as $orderDetail) {
            $orderDetail->set('idOrder', $order->get('id'));
            $orderDetail->save();
        }
    
        return $orderSaved ? "Orden registrada correctamente." : "Error al registrar la orden.";
    }

    public function viewOrderDetail($orderId)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE id = {$orderId}";
        $result = $db->execSQL($sql);
        $orderData = $result->fetch_assoc();
        
        $orderDetails = new OrderDetail();
        $orderDetails->set('idOrder', $orderId);
        $detailsData = $orderDetails->all();
        
        return ['order' => $orderData, 'details' => $detailsData];
    }

    public function anularOrder($id)
    {
        $this->ensureAnularColumnExists();

        $db = new ConexDB();
        $conn = $db->getConex();

        $sql = "UPDATE orders SET anular = 1 WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        } else {

            return false;
        }
    }
    
    public function generateOrdersReport($startDate, $endDate)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND anular = 0";
        $result = $db->execSQL($sql);
        $ordersData = $result->fetch_all(MYSQLI_ASSOC);
        
        $totalRevenue = 0;
        $dishSales = [];
        foreach ($ordersData as $orderData) {
            $orderDetails = new OrderDetail();
            $orderDetails->set('idOrder', $orderData['id']);
            $detailsData = $orderDetails->all();
            
            foreach ($detailsData as $detail) {
                $dishId = $detail['idDish'];
                if (!isset($dishSales[$dishId])) {
                    $dishSales[$dishId] = 0;
                }
                $dishSales[$dishId] += $detail['quantity'];
            }
            
            $totalRevenue += $orderData['total'];
        }
        
        arsort($dishSales);
        
        return ['orders' => $ordersData, 'totalRevenue' => $totalRevenue, 'dishSales' => $dishSales];
    }

    public function generateCancelledOrdersReport($startDate, $endDate)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND anular = 1";
        $result = $db->execSQL($sql);
        $ordersData = $result->fetch_all(MYSQLI_ASSOC);
        
        $totalCancelled = 0;
        foreach ($ordersData as $orderData) {
            $totalCancelled += $orderData['total'];
        }

        return ['orders' => $ordersData, 'totalCancelled' => $totalCancelled];
    }

    public function queryAllOrders()
    {
        $db = new ConexDB();
        $sql = "SELECT o.*, t.name AS table_name FROM orders o JOIN restaurant_tables t ON o.idTable = t.id";
        $result = $db->execSQL($sql);

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $order = new Order();
            $order->set('id', $row['id']);
            $order->set('dateOrder', $row['dateOrder']);
            $order->set('total', $row['total']);
            $order->set('idTable', $row['idTable']);
            $order->set('anulada', isset($row['anular']) ? (bool)$row['anular'] : false);
            $order->set('table_name', $row['table_name']);
            $orders[] = $order;
        }

        return $orders;
    }

    public function getAllTables()
    {
        $db = new ConexDB();
        $result = $db->execSQL("SELECT * FROM restaurant_tables");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllDishes()
    {
        $db = new ConexDB();
        $result = $db->execSQL("SELECT * FROM dishes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
