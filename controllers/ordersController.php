<?php

namespace app\controllers;
use app\models\entities\Order;

class OrdersController
{
    public function queryAllOrders()
    {
        $order= new Order();
        $data= $order->all();
        return $data;
    }

    public function saveNewCatregoy($request)
    {
        $order= new Order();
        $order->set('dateOrder', $request['dateOrderInput']);
        $order->set('total', $request['totalInput']);
        $order->set('idTable', $request['idTableInput']);
        return $order->save();
    }

    public function updateCategory($request)
    {
        $order = new Order();
        $order->set('id', $request['idInput']);
        $order->set('dateOrder', $request['dateOrderInput']);
        $order->set('total', $request['totalInput']);
        $order->set('idTable', $request['idTableInput']);
        return $order->update();
    }

    public function deleteCategory($id)
    {
        $order = new Order();
        $order->set('id', $id);
        return $order->delete();
    }
    
}