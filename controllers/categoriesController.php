<?php

namespace app\controllers;
use app\models\entities\Category;
use app\models\drivers\ConexDB;

class CategoriesController
{
    public function queryAllCategories()
    {
        $category = new Category();
        $data = $category->all();
        return $data;
    }

    public function saveNewCategory($request)
    {
        $category = new Category();
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
        $conex = new ConexDB();
        $sql = "SELECT * FROM dishes WHERE idCategory = " . $category->get('id');
        $resultDb = $conex->execSQL($sql);

        if ($resultDb->num_rows > 0) {
            $conex->close();
            return "No se puede eliminar la categoría porque está asociada a uno o más platos.";
        }
        $deleted = $category->delete();
        $conex->close();

        return $deleted ? "Categoría eliminada correctamente." : "Error al eliminar la categoría.";
    }
}