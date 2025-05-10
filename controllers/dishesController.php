<?php

namespace app\controllers;
use app\models\entities\Dishe;

class DishesController
{
    public function queryAllDishes()
    {
        $dishe= new Dishe();
        $data= $dishe->all();
        return $data;
    }

    public function saveNewDishe($request)
    {
        $dishe= new Dishe();
        $dishe->set('description', $request['descriptionInput']);
        $dishe->set('price', $request['priceInput']);
        $dishe->set('idCategory', $request['idCategory']);
        return $dishe->save();
    }

    public function updateDishe($request)
    {
        $dishe = new Dishe();
        $dishe->set('id', $request['idInput']);
        $dishe->set('description', $request['descriptionInput']);
        $dishe->set('price', $request['priceInput']);
        $dishe->set('idCategory', $request['idCategory']);
        return $dishe->update();
    }

    public function deleteDishe($id)
    {
        $dishe = new Dishe();

        $db = new \app\models\drivers\ConexDB();
        $sql = "SELECT COUNT(*) AS count FROM order_details WHERE idDish = $id";
        $result = $db->execSQL($sql);
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            $db->close();
            return false;
        }

        $dishe->set('id', $id);
        $result = $dishe->delete();

        $db->close();
        return $result;
    }
    
}