<?php

namespace app\models\entities;
include_once __DIR__ . '/entity.php';
use app\models\drivers\ConexDB;

class OrderDetail extends Entity
{
    protected $idOrder;
    protected $idDish;
    protected $quantity;
    protected $price;

    public function all()
    {
        $sql = "SELECT * FROM order_details WHERE idDish = {$this->idDish}";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);

        $orderDetails = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $orderDetail = new OrderDetail();
                $orderDetail->set('idOrder', $rowDb['idOrder']);
                $orderDetail->set('idDish', $rowDb['idDish']);
                $orderDetail->set('quantity', $rowDb['quantity']);
                $orderDetail->set('price', $rowDb['price']);
                array_push($orderDetails, $orderDetail);
            }
        }

        $conex->close();
        return $orderDetails;
    }

    public function save()
    {
        $sql = "INSERT INTO order_details (idOrder, idDish, quantity, price) 
                VALUES ({$this->idOrder}, {$this->idDish}, {$this->quantity}, {$this->price})";
        $conex = new ConexDB();
        return $conex->execSQL($sql);
    }

    public function update()
    {
        $sql = "UPDATE order_details 
                SET quantity = {$this->quantity}, price = {$this->price} 
                WHERE idOrder = {$this->idOrder} AND idDish = {$this->idDish}";
        $conex = new ConexDB();
        return $conex->execSQL($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM order_details WHERE idOrder = {$this->idOrder} AND idDish = {$this->idDish}";
        $conex = new ConexDB();
        return $conex->execSQL($sql);
    }
}
