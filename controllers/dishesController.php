<?php
namespace app\controllers;

use app\models\entities\Dishe;
use app\models\entities\Category;
use app\models\entities\OrderDetail;

class DishesController
{
    // Registrar un nuevo plato
    public function saveNewDish($request)
    {
        // Asegurarse de que el formulario envía correctamente el valor de idCategoryInput
        if (isset($request['idCategoryInput'])) {
            $dish = new Dishe();
            $dish->set('description', $request['descriptionInput']);
            $dish->set('price', $request['priceInput']);
            $dish->set('idCategory', $request['idCategoryInput']);  // Cambié a 'idCategoryInput'
            return $dish->save() ? "Plato registrado correctamente." : "Error al registrar el plato.";
        } else {
            return "Error: La categoría no fue seleccionada.";
        }
    }

    // Actualizar un plato
    public function updateDish($request)
    {
        $dish = new Dishe();
        $dish->set('id', $request['idInput']);
        $dish->set('description', $request['descriptionInput']);
        $dish->set('price', $request['priceInput']);
        $dish->set('idCategory', $request['idCategoryInput']);  // Cambié a 'idCategoryInput'
        return $dish->update() ? "Plato actualizado correctamente." : "Error al actualizar el plato.";
    }

    // Eliminar un plato
    public function deleteDish($id)
    {
        $dish = new Dishe();
        $dish->set('id', $id);

        // Verificar si el plato está asociado a algún pedido antes de eliminar
        $orderDetails = new \app\models\entities\OrderDetail();
        $orderDetails->set('idDish', $id);
        $orderDetailsData = $orderDetails->all();
        
        if (count($orderDetailsData) > 0) {
            return "No se puede eliminar el plato porque está asociado a una orden.";
        }

        return $dish->delete() ? "Plato eliminado correctamente." : "Error al eliminar el plato.";
    }

    // Listar todos los platos
    public function queryAllDishes($categoryId = null)
    {
        $dish = new Dishe();
    
        // Si se pasa un categoryId, se filtra por categoría
        if ($categoryId !== null) {
            $dish->set('idCategory', $categoryId);
        }
    
        return $dish->all(); // Obtener los platos según la categoría (si se pasa)
    }

    // Obtener todas las categorías
    public function queryAllCategories()
    {
        $categoriesController = new \app\controllers\CategoriesController();
        return $categoriesController->queryAllCategories();  // Esto devuelve las categorías desde CategoriesController
    }
}
