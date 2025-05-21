<?php

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Order extends Entity
{
    protected $id = null;
    protected $dateOrder = null;
    protected $total = null;
    protected $idTable = null;
    protected $anular = 0;

    public function all()
    {
        $sql = "SELECT * FROM orders";
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
                $order->set('anular', $rowDb['anular'] ?? 0);
                array_push($orders, $order);
            }
        }

        $conex->close();
        return $orders;
    }

    public function save()
    {
        $sql = "INSERT INTO orders (dateOrder, total, idTable, anular) VALUES ('{$this->dateOrder}', {$this->total}, {$this->idTable}, {$this->anular})";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);

        if ($result) {
            $idResult = $conex->execSQL("SELECT LAST_INSERT_ID() AS id");
            $row = $idResult->fetch_assoc();
            $this->id = $row['id'];
        }

        $conex->close();
        return $result;
    }

    public function update()
    {
        $sql = "UPDATE orders SET idTable = {$this->idTable} WHERE id = {$this->id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $conex->close();
        return $result;
    }

    public function delete()
    {
        $sql = "DELETE FROM orders WHERE id = {$this->id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $conex->close();
        return $result;
    }

    public function cancelOrder()
    {
        $sql = "UPDATE orders SET anular = 1 WHERE id = {$this->id}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $conex->close();
        return $result;
    }

    public function findByTableId($idTable)
    {
        $sql = "SELECT * FROM orders WHERE idTable = {$idTable} AND anular = 0";
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
                $order->set('anular', $rowDb['anular']);
                array_push($orders, $order);
            }
        }

        $conex->close();
        return $orders;
    }

    public function removeTableAssociation($idTable)
    {
        $sql = "UPDATE orders SET idTable = NULL WHERE idTable = {$idTable}";
        $conex = new ConexDB();
        $result = $conex->execSQL($sql);
        $conex->close();
        return $result;
    }
}
