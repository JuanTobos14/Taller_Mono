<?php
// Incluir las clases necesarias
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/category.php';
include '../controllers/categoriesController.php';

use app\controllers\CategoriesController;

// Verificar si se ha recibido el ID de la categoría a eliminar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id']; // Obtener el ID de la categoría desde la URL

    // Crear una instancia del controlador de categorías
    $controller = new CategoriesController();
    
    // Llamar al método para eliminar la categoría
    $result = $controller->deleteCategory($id);

    // Verificar si la eliminación fue exitosa o si ocurrió un error
    if ($result) {
        // Si la categoría se eliminó correctamente, redirigir a la página de categorías
        header("Location: categories.php");
        exit;
    } else {
        // Si no se pudo eliminar la categoría (por estar asociada a platos u otros problemas), redirigir con error
        header("Location: categories.php?deleteError=1");
        exit;
    }
} else {
    // Si no se pasa un ID válido, redirigir a la página de categorías
    header("Location: categories.php");
    exit;
}
?>
