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
    // Verificar y crear la columna 'anular' si no existe
    private function ensureAnularColumnExists()
    {
        $db = new ConexDB();
        
        // Verificar si la columna 'anular' existe en la tabla 'orders'
        $checkSql = "SHOW COLUMNS FROM orders LIKE 'anular'";
        $result = $db->execSQL($checkSql);
        
        // Si no existe la columna, crearla
        if ($result->num_rows == 0) {
            $alterSql = "ALTER TABLE orders ADD COLUMN anular TINYINT(1) DEFAULT 0";
            $db->execSQL($alterSql);
        }
    }

    // Registrar una nueva orden
    public function saveNewOrder($request)
    {
        // Datos de la orden
        $order = new Order();
        $order->set('dateOrder', $request['dateOrderInput']);
        $order->set('idTable', $request['idTableInput']);
        
        // Obtener platos y calcular el total
        $total = 0;
        $orderDetails = [];
        foreach ($request['orderDetails'] as $item) {
            $db = new ConexDB();
            $sql = "SELECT * FROM dishes WHERE id = {$item['idDish']}";
            $result = $db->execSQL($sql);
            $dishDetails = $result->fetch_assoc(); // Obtener el plato
            
            $priceUnit = $dishDetails['price'];  // Obtener el precio del plato
            $quantity = $item['quantity'];
            $total += $quantity * $priceUnit;
            
            $orderDetail = new OrderDetail();
            $orderDetail->set('idDish', $item['idDish']);
            $orderDetail->set('quantity', $quantity);
            $orderDetail->set('price', $priceUnit);
            $orderDetails[] = $orderDetail;
        }
    
        // Establecer el total
        $order->set('total', $total);
        
        // Guardar la orden
        $orderSaved = $order->save();
        foreach ($orderDetails as $orderDetail) {
            $orderDetail->set('idOrder', $order->get('id'));
            $orderDetail->save();
        }
    
        return $orderSaved ? "Orden registrada correctamente." : "Error al registrar la orden.";
    }

    // Ver detalle de la orden
    public function viewOrderDetail($orderId)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE id = {$orderId}";
        $result = $db->execSQL($sql);
        $orderData = $result->fetch_assoc(); // Obtener los datos de la orden
        
        $orderDetails = new OrderDetail();
        $orderDetails->set('idOrder', $orderId);
        $detailsData = $orderDetails->all(); // Obtener los detalles de la orden
        
        return ['order' => $orderData, 'details' => $detailsData];
    }

    // Anular una orden
    public function anularOrder($id)
    {
        // Verificar y crear la columna 'anular' si no existe
        $this->ensureAnularColumnExists();

        // Crear una nueva instancia de ConexDB
        $db = new ConexDB();
        $conn = $db->getConex(); // Usamos el getter para obtener la conexión

        // Consulta SQL para actualizar el campo de anulación de la orden
        $sql = "UPDATE orders SET anular = 1 WHERE id = ?";
        
        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular el parámetro a la consulta preparada
            $stmt->bind_param("i", $id); // "i" es para indicar que $id es un entero

            // Ejecutar la consulta
            return $stmt->execute();
        } else {
            // Si la preparación falla, devolver false
            return false;
        }
    }
    
    // Generar reporte de órdenes (No anuladas)
    public function generateOrdersReport($startDate, $endDate)
    {
        $db = new ConexDB();
        $sql = "SELECT * FROM orders WHERE dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND anular = 0";
        $result = $db->execSQL($sql);
        $ordersData = $result->fetch_all(MYSQLI_ASSOC);
        
        // Calcular total recaudado y ranking de platos vendidos
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
        
        // Ordenar los platos vendidos por la cantidad (de más a menos)
        arsort($dishSales);
        
        return ['orders' => $ordersData, 'totalRevenue' => $totalRevenue, 'dishSales' => $dishSales];
    }

    // Generar reporte de órdenes anuladas
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
            $order->set('anulada', isset($row['anular']) ? (bool)$row['anular'] : false); // Manejo de anulación
            $order->set('table_name', $row['table_name']); // campo adicional para mostrar nombre de mesa
            $orders[] = $order;
        }

        return $orders;
    }

    // Obtener todas las mesas
    public function getAllTables()
    {
        $db = new ConexDB();
        $result = $db->execSQL("SELECT * FROM restaurant_tables");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener todos los platos
    public function getAllDishes()
    {
        $db = new ConexDB();
        $result = $db->execSQL("SELECT * FROM dishes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
