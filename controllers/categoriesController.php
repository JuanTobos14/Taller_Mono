<?php
namespace app\controllers;
// Cargar manualmente las clases necesarias
require_once __DIR__ . '/../models/entities/Category.php';
require_once __DIR__ . '/../models/entities/Dishe.php';
require_once __DIR__ . '/../models/drivers/ConexDB.php';

use app\models\entities\Category;
use app\models\entities\Dishe;
use app\models\drivers\ConexDB;

class CategoriesController
{
    private $conex;

    public function __construct()
    {
        // Inicializamos la conexión a la base de datos
        $this->conex = new ConexDB();
    }

    // Registrar una nueva categoría
    public function saveNewCategory($request)
    {
        try {
            $category = new Category();
            $category->set('name', $request['nameInput']);

            if ($category->save()) {
                return "Categoría registrada correctamente.";
            } else {
                return "Error al registrar la categoría.";
            }
        } catch (\Exception $e) {
            return "Error al registrar la categoría: " . $e->getMessage();
        }
    }

    // Actualizar una categoría
    public function updateCategory($data)
    {
        try {
            $id = $data['idInput'];
            $name = $data['nameInput'];
            
            $query = "UPDATE categories SET name = '{$name}' WHERE id = {$id}";
            
            if ($this->conex->execSQL($query)) {
                return "Categoría actualizada correctamente.";
            } else {
                return "Error al actualizar la categoría.";
            }
        } catch (\Exception $e) {
            return "Error al actualizar la categoría: " . $e->getMessage();
        }
    }

    // Eliminar una categoría
    public function deleteCategory($id)
    {
        try {
            $category = new Category();
            $category->set('id', $id);

            $dishe = new Dishe();
            $dishe->set('idCategory', $id);
            $dishes = $dishe->all();
            
            if (count($dishes) > 0) {
                return "No se puede eliminar la categoría porque tiene platos asociados.";
            }

            if ($category->delete()) {
                return "Categoría eliminada correctamente.";
            } else {
                return "Error al eliminar la categoría.";
            }
        } catch (\Exception $e) {
            return "Error al eliminar la categoría: " . $e->getMessage();
        }
    }

    // Listar todas las categorías
    public function queryAllCategories()
    {
        try {
            $category = new Category();
            $categories = $category->all();  // Obtener todas las categorías
            
            // Asegúrate de que siempre retorne un array
            return is_array($categories) ? $categories : [];
        } catch (\Exception $e) {
            return "Error al listar las categorías: " . $e->getMessage();
        }
    }
}
