<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/order.php';
include '../../controllers/ordersController.php';

use app\controllers\OrdersController;

$controller = new OrdersController();
$result = $controller->saveNewOrder($_POST);

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
        echo '<p>Orden guardada exitosamente.</p>';
    } else {
        echo '<p>No se pudo guardar la orden.</p>';
    }
    ?>
    <a href="orders.php">Volver a las órdenes</a>
</body>
</html>
