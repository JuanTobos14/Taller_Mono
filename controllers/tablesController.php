<?php

namespace app\controllers;
use app\models\entities\Table;

class TablesController
{
    public function queryAllCategories()
    {
        $table= new Table();
        $data= $table->all();
        return $data;
    }

    public function saveNewCatregoy($request)
    {
        $table= new Table();
        $table->set('name', $request['nameInput']);
        return $table->save();
    }

    public function updateCategory($request)
    {
        $table = new Table();
        $table->set('id', $request['idInput']);
        $table->set('name', $request['nameInput']);
        return $table->update();
    }

    public function deleteCategory($id)
    {
        $table = new Table();
        $table->set('id', $id);
        return $table->delete();
    }
    
}