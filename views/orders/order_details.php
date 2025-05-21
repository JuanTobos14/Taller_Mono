<?php
require_once __DIR__ . '/../../controllers/OrderDetailsController.php';

use app\controllers\OrderDetailsController;

// Obtener el ID de la orden desde la URL (parámetro GET)
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : null;

if ($orderId) {
    // Recuperar los detalles de la orden desde el controlador
    $controller = new OrderDetailsController();
    $orderDetails = $controller->viewOrderDetails($orderId); // Devuelve todos los detalles de la orden
} else {
    $orderDetails = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Orden</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
        <h1>Detalles de la Orden</h1>

        <!-- Mostrar la ID de la orden recibida -->
        <?php if ($orderId): ?>
            <h2>Detalles de la Orden #<?php echo htmlspecialchars($orderId); ?></h2>
        <?php else: ?>
            <p>No se ha proporcionado un ID de orden válido.</p>
        <?php endif; ?>

        <!-- Si los detalles de la orden están disponibles, se muestran en la tabla -->
        <?php if ($orderDetails !== null): ?>
            <table>
                <thead>
                    <tr>
                        <th>Plato</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalOrder = 0;  // Variable para almacenar el total de la orden
                    foreach ($orderDetails as $detail) {
                        $subtotal = $detail['quantity'] * $detail['price'];  // Calcular el subtotal
                        $totalOrder += $subtotal;  // Sumar al total de la orden
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['dishName']); ?></td>
                            <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                            <td><?php echo number_format($detail['price'], 2, ',', '.'); ?></td>
                            <td><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h3>Total de la Orden: <?php echo number_format($totalOrder, 2, ',', '.'); ?></h3>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !$orderDetails): ?>
            <p>No se encontraron detalles para la orden con ID #<?php echo htmlspecialchars($orderId); ?>.</p>
        <?php endif; ?>

        <a href="../orders/orders.php">Volver a las Órdenes</a>
    </div>
</body>
</html>
