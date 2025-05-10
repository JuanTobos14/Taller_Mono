<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();
$id = $_GET['id'];

$result = $controller->deleteCategory($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Categoría</title>
</head>
<body>
    <h1>Resultado de la eliminación de la categoría</h1>
    <?php
    echo "<p>" . $result . "</p>";
    ?>
    <a href="../categories.php">Volver a Categorías</a>
</body>
</html>
