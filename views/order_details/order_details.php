<?php
include_once "../../models/drivers/conexDB.php";

// Crear una instancia de la clase ConexDB
$conex = new \app\models\drivers\ConexDB();
$conn = $conex->execSQL('SELECT 1'); // Para verificar que la conexión funciona correctamente.

if (!isset($_GET['id'])) {
    echo "ID de orden no especificado.";
    exit;
}

$idOrder = intval($_GET['id']);

// Obtener datos de la orden
$orderRes = $conex->execSQL("SELECT o.*, t.name as table_name FROM orders o JOIN restaurant_tables t ON o.idTable = t.id WHERE o.id = $idOrder");
if ($orderRes->num_rows === 0) {
    echo "Orden no encontrada.";
    exit;
}
$order = $orderRes->fetch_assoc();

// Obtener detalles
$detailsRes = $conex->execSQL("
    SELECT d.description, od.quantity, od.price, (od.quantity * od.price) AS subtotal
    FROM order_details od
    JOIN dishes d ON od.idDish = d.id
    WHERE od.idOrder = $idOrder
");

?>

<h2>Detalle de la Orden #<?= $order['id'] ?></h2>
<p><strong>Fecha:</strong> <?= $order['dateOrder'] ?></p>
<p><strong>Mesa:</strong> <?= $order['table_name'] ?></p>
<p><strong>Total:</strong> $<?= number_format($order['total'], 2) ?></p>
<p><strong>Anulada:</strong> <?= $order['isCancelled'] ? 'Sí' : 'No' ?></p>

<h3>Platos Ordenados</h3>
<table border="1">
    <tr>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($detalle = $detailsRes->fetch_assoc()): ?>
    <tr>
        <td><?= $detalle['description'] ?></td>
        <td><?= $detalle['quantity'] ?></td>
        <td>$<?= number_format($detalle['price'], 2) ?></td>
        <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="orders.php">← Volver al listado de órdenes</a>
