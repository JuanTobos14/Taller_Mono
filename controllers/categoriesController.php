<?php

namespace app\controllers;
use app\models\entities\Category;

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
    // Verificar si la categoría está asociada a algún plato antes de eliminar
    $category = new Category();
    $category->set('id', $id);
    
    // Verificar si la categoría está asociada a platos
    $platosAsociados = $category->getPlatosAsociados(); // Método que debes crear para obtener los platos relacionados
    
    if (count($platosAsociados) > 0) {
        return false;  // No se puede eliminar
    }
    
    return $category->delete();  // Si no está asociada, eliminar
    }
}
