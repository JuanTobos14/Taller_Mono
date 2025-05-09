<?php

namespace app\controllers;
use app\models\entities\Category;

class CategoriesController
{
    public function queryAllCategories()
    {
        $category= new Category();
        $data= $category->all();
        return $data;
    }

    public function saveNewCatregoy($request)
    {
        $category= new Category();
        $category->set('name', $request['nameInput']);
        return $category->save();
    }

    public function updateCategory($request)
    {
        $category = new Category();
        $category->set('id', $request['idInput']);
        $category->set('name', $request['nameInput']);
        return $category->update();
    }

    public function deleteCategory($id)
    {
        $category = new Category();
        $category->set('id', $id);
        return $category->delete();
    }
    
}