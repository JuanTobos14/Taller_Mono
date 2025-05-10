<?php
namespace app\models\entities;

use app\models\drivers\ConexDB;

class OrderDetail extends Entity
{
    protected $orderId;
    protected $dishId;
    protected $quantity;
    protected $price;

    public function save()
    {
        $sql = "INSERT INTO order_details (order_id, dish_id, quantity, price) VALUES ({$this->orderId}, {$this->dishId}, {$this->quantity}, {$this->price})";
        $conex = new ConexDB();
        return $conex->execSQL($sql);
    }
}
