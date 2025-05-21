<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();

if (!empty($_POST['idInput'])) {
    $result = $controller->updateCategory($_POST);
} else {
    $result = $controller->saveNewCategory($_POST);
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
    <?php
    if ($result) {
        echo '<p>Datos ' . (empty($_POST['idInput']) ? 'GUARDADOS' : 'ACTUALIZADOS') . ' correctamente.</p>';
    } else {
        echo '<p>No se pudo ' . (empty($_POST['idInput']) ? 'guardar' : 'actualizar') . ' los datos.</p>';
    }
    ?>
    <a class="add-link" href="categories.php">Volver</a>
</body>
</html>
