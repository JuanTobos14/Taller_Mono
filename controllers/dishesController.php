<?php
namespace app\controllers;

use app\models\entities\Dishe;
use app\models\entities\Category;
use app\models\entities\OrderDetail;

class DishesController
{
    public function saveNewDish($request)
    {
        if (isset($request['idCategoryInput'])) {
            $dish = new Dishe();
            $dish->set('description', $request['descriptionInput']);
            $dish->set('price', $request['priceInput']);
            $dish->set('idCategory', $request['idCategoryInput']);
            return $dish->save() ? "Plato registrado correctamente." : "Error al registrar el plato.";
        } else {
            return "Error: La categoría no fue seleccionada.";
        }
    }

    public function updateDish($request)
    {
        $dish = new Dishe();
        $dish->set('id', $request['idInput']);
        $dish->set('description', $request['descriptionInput']);
        $dish->set('price', $request['priceInput']);
        $dish->set('idCategory', $request['idCategoryInput']);
        return $dish->update() ? "Plato actualizado correctamente." : "Error al actualizar el plato.";
    }

    public function deleteDish($id)
    {
        $dish = new Dishe();
        $dish->set('id', $id);

        $orderDetails = new \app\models\entities\OrderDetail();
        $orderDetails->set('idDish', $id);
        $orderDetailsData = $orderDetails->all();
        
        if (count($orderDetailsData) > 0) {
            return "No se puede eliminar el plato porque está asociado a una orden.";
        }

        return $dish->delete() ? "Plato eliminado correctamente." : "Error al eliminar el plato.";
    }

    public function queryAllDishes($categoryId = null)
    {
        $dish = new Dishe();
    
        if ($categoryId !== null) {
            $dish->set('idCategory', $categoryId);
        }
    
        return $dish->all();
    }

    public function queryAllCategories()
    {
        $categoriesController = new \app\controllers\CategoriesController();
        return $categoriesController->queryAllCategories();
    }
}
