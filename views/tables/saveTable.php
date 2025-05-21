<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();

$id = $_POST['idInput'] ?? null;
$name = $_POST['nameInput'];

if ($id) {
    $result = $controller->updateTable($id, $name);
} else {
    $result = $controller->saveNewTable($_POST);
}
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

    <p><?= $result ?></p>

    <a href="restaurant_tables.php">Volver a las Mesas</a>
</body>
</html>