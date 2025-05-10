<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();

$id = $_GET['id'];
$result = $controller->deleteTable($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar mesa</title>
</head>
<body>
    <h1>Resultado de la eliminación</h1>
    <p><?= $result ? 'Mesa eliminada correctamente.' : 'No se pudo eliminar la mesa. Puede estar relacionada con alguna orden.' ?></p>
    <a href="../restaurant_tables.php">Volver</a>
</body>
</html>
