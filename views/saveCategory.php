<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/category.php';
include '../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();
$result = empty($_POST['idInput'])
    ? $controller->saveNewCategory($_POST)
    : $controller->updateCategory($_POST);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la operación</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <br>
    <?php
    if ($result) {
        echo '<p>Datos GUARDADOS</p>';
    } else {
        echo '<p>No se pudo GUARDAR los datos</p>';
    }
    ?>
    <a href="categories.php">Volver</a>
</body>
</html>
