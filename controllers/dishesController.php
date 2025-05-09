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

    public function saveNewCatregoy($request)
    {
        $dishe= new Dishe();
        $dishe->set('description', $request['descriptionInput']);
        $dishe->set('price', $request['priceInput']);
        $dishe->set('idCategory', $request['idCategory']);
        return $dishe->save();
    }

    public function updateCategory($request)
    {
        $dishe = new Dishe();
        $dishe->set('id', $request['idInput']);
        $dishe->set('description', $request['descriptionInput']);
        $dishe->set('price', $request['priceInput']);
        $dishe->set('idCategory', $request['idCategory']);
        return $dishe->update();
    }

    public function deleteCategory($id)
    {
        $dishe = new Dishe();
        $dishe->set('id', $id);
        return $dishe->delete();
    }
    
}