<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();

$result = empty($_POST['idInput']) 
    ? $controller->saveNewTable($_POST) 
    : $controller->updateTable($_POST);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <p><?= $result ? 'Datos GUARDADOS' : 'No se pudo GUARDAR los datos' ?></p>
    <a href="../restaurant_tables.php">Volver</a>
</body>
</html>