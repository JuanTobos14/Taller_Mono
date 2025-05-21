<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/order.php';
include '../../models/entities/restaurant_table.php';
include '../../models/entities/dishe.php';
include '../../controllers/ordersController.php';
include '../../controllers/tablesController.php';
include '../../controllers/dishesController.php';

use app\controllers\OrdersController;
use app\controllers\TablesController;
use app\controllers\DishesController;

$orderController = new OrdersController();
$orders = $orderController->queryAllOrders();

$tableController = new TablesController();
$tables = $tableController->queryAllTables();

$dishController = new DishesController();
$dishes = $dishController->queryAllDishes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes</title>
</head>
<body>
    <h1>Órdenes</h1>

    <div class="menu">
        <a href="../../index.html/..">Pag. Principal</a>
        <a href="../categories/categories.php">Categorías</a>
        <a href="../dishes/dishes.php">Platos</a>
        <a href="../orders/orders.php">Ordenes</a>
        <a href="../order_details/order_details.php">Detalles Orden</a>
        <a href="../tables/restaurant_tables.php">Mesas</a>
    </div>

    <a href="../orders/form_orders.php">Registrar nueva orden</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Mesa</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order->get('id') ?></td>
                    <td><?= $order->get('dateOrder') ?></td>
                    <td><?= $order->get('table_name') ?></td>
                    <td><?= $order->get('total') ?></td>
                    <td>
                        <?php if (!$order->get('anulada')): ?>
                            <a href="cancelOrder.php?id=<?= $order->get('id') ?>" onclick="return confirm('¿Estás seguro de que deseas anular esta orden?');">Anular Orden</a>
                        <?php else: ?>
                            <span>Orden Anulada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
