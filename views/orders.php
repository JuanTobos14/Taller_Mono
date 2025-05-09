<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/order.php';
include '../controllers/ordersController.php';

use app\controllers\OrdersController;

$controller=new OrdersController();
$orders=$controller->queryAllOrders();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes</title>
</head>
<body>
    <h1>Ordenes</h1>

    <div class="menu">
        <a href="categories.php">Categorías</a>
        <a href="dishes.php">Platos</a>
        <a href="orders.php">Ordenes</a>
        <a href="order_details.php">Detalles Orden</a>
        <a href="restaurant_tables.php">Mesas</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Mesa</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($orders as $order){
                    echo '<tr>';
                    echo '<td>'.$order->get('id').'</td>';
                    echo '<td>'.$order->get('dateOrder').'</td>';
                    echo '<td>'.$order->get('total').'</td>';
                    echo '<td>'.$order->get('idTable').'</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
        </tbody>
    </table>
</body>
</html>