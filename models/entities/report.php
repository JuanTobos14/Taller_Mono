<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Report
{
    public function getOrdersReport($startDate, $endDate)
    {
        $sql = "SELECT * FROM orders WHERE dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND isCancelled = 0";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $orders = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $order = new Order();
                $order->set('id', $rowDb['id']);
                $order->set('dateOrder', $rowDb['dateOrder']);
                $order->set('total', $rowDb['total']);
                $order->set('idTable', $rowDb['idTable']);
                array_push($orders, $order);
            }
        }
        $conex->close();
        return $orders;
    }

    public function getCancelledOrdersReport($startDate, $endDate)
    {
        $sql = "SELECT * FROM orders WHERE dateOrder BETWEEN '{$startDate}' AND '{$endDate}' AND isCancelled = 1";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $orders = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $order = new Order();
                $order->set('id', $rowDb['id']);
                $order->set('dateOrder', $rowDb['dateOrder']);
                $order->set('total', $rowDb['total']);
                $order->set('idTable', $rowDb['idTable']);
                array_push($orders, $order);
            }
        }
        $conex->close();
        return $orders;
    }
}