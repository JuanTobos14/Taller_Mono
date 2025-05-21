<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();
$id = $_GET['id'] ?? null;
$resultMessage = '';

if ($id !== null) {
    $resultMessage = $controller->deleteCategory($id);
} else {
    $resultMessage = "ID de categoría no especificado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la operación</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <h1>Resultado de la operación</h1>
    <br>
    <p><?= $resultMessage ?></p>
    <a class="add-link" href="categories.php">Volver</a>
</body>
</html>