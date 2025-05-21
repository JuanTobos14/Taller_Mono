<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();
$id = $_GET['id'];

$result = $controller->deleteCategory($id);

// Redirigir a categories.php con el parámetro de resultado
header("Location: categories.php?result=" . ($result ? 'success' : 'error'));
exit();
?>