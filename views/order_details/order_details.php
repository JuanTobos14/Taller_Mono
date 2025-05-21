<?php
require_once __DIR__ . '/../../controllers/OrderDetailsController.php';

use app\controllers\OrderDetailsController;

// Comprobar si se envió un ID de orden a través del formulario
$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;

if ($orderId) {
    // Recuperar los detalles de la orden
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
</head>
<body>
    <h1>Buscar Detalles de la Orden</h1>

    <!-- Formulario para ingresar el ID de la orden -->
    <form action="order_details.php" method="post">
        <label for="orderId">ID de la Orden:</label>
        <input type="text" id="orderId" name="orderId" required>
        <button type="submit">Ver Detalles</button>
    </form>

    <?php if ($orderDetails !== null): ?>
        <!-- Mostrar detalles de la orden -->
        <h2>Detalles de la Orden #<?php echo htmlspecialchars($orderId); ?></h2>

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
                $totalOrder = 0;
                foreach ($orderDetails as $detail) {
                    $subtotal = $detail['quantity'] * $detail['price'];  // Calcular el subtotal
                    $totalOrder += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['dishName']); ?></td>
                        <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                        <td><?php echo number_format($detail['price'], 2, ',', '.'); ?>€</td>
                        <td><?php echo number_format($subtotal, 2, ',', '.'); ?>€</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Total de la Orden: <?php echo number_format($totalOrder, 2, ',', '.'); ?>€</h3>

    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No se encontró una orden con el ID proporcionado.</p>
    <?php endif; ?>

    <br>
    <a href="../orders/orders.php">Volver a las Órdenes</a>
</body>
</html>
