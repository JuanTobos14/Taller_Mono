<?php 
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/order.php';
include '../../controllers/ordersController.php';

use app\controllers\OrdersController;

$controller = new OrdersController();
$id = $_GET['id'];

$result = $controller->anularOrder($id);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anular Orden</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
        <h1>Resultado de la anulación de la orden</h1>
        <?php
        echo "<p class='message " . ($result ? 'success' : 'error') . "'>" . ($result ? "Orden anulada exitosamente." : "No se pudo anular la orden.") . "</p>";
        ?>
        <a href="orders.php">Volver a las órdenes</a>
    </div>
</body>
</html>
