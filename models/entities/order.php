<?php

namespace app\models\entities;
use app\models\drivers\ConexDB;

class Order extends Entity
{
    protected $id = null;
    protected $dateOrder = null;
    protected $total = null;
    protected $idTable = null;

    public function all()
    {
        $sql = "select * from orders";
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