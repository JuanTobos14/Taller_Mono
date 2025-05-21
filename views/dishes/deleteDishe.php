<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/dishe.php';
include '../../controllers/dishesController.php';

use app\controllers\DishesController;

$controller = new DishesController();
$id = $_GET['id'];

$result = $controller->deleteDish($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Plato</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
        <h1>Resultado de la eliminación del plato</h1>
        <p><?= $result ? "Plato eliminado exitosamente." : "No se pudo eliminar el plato." ?></p>
        <a href="dishes.php" class="add-link">Volver a los platos</a>
    </div>
</body>
</html>
