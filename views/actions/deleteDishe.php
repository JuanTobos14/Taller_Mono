<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/dishe.php';
include '../controllers/dishesController.php';

use app\controllers\DishesController;

$controller = new DishesController();
$id = $_GET['id'];

$result = $controller->deleteDishe($id);

if ($result) {
    $message = "Plato eliminado correctamente.";
} else {
    $message = "No se pudo eliminar el plato porque está asociado a órdenes.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Plato</title>
</head>
<body>
    <h1>Resultado de la eliminación del plato</h1>
    <p><?= $message ?></p>
    <a href="dishes.php">Volver a Platos</a>
</body>
</html>
