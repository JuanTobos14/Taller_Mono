<?php
include_once '../../models/drivers/conexDB.php';
include_once '../../controllers/OrdersController.php';

use app\controllers\OrdersController;

$controller = new OrdersController();
$mesas = $controller->getAllTables();
$platos = $controller->getAllDishes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nueva Orden</title>
</head>
<body>
    
    <h1>Registrar Nueva Orden</h1>
    <form method="POST" action="saveOrder.php">
        <label for="fecha">Fecha:</label>
        <input type="datetime-local" id="fecha" name="dateOrderInput" required><br>
    
        <label for="mesa">Mesa:</label>
        <select id="mesa" name="idTableInput" required>
            <?php foreach ($mesas as $mesa): ?>
                <option value="<?= $mesa['id'] ?>"><?= $mesa['name'] ?></option>
            <?php endforeach; ?>
        </select><br>
            
        <h3>Platos:</h3>
        <div id="platos-container">
            <div class="plato">
                <select name="orderDetails[0][idDish]" required>
                    <?php foreach ($platos as $plato): ?>
                        <option value="<?= $plato['id'] ?>" data-precio="<?= $plato['price'] ?>">
                            <?= $plato['description'] ?> - $<?= $plato['price'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="orderDetails[0][quantity]" min="1" value="1" required>
            </div>
        </div>
                    
        <button type="button" onclick="agregarPlato()">Agregar Plato</button><br><br>
        <div>
            <button type="submit">Guardar Orden</button>
        </div>
        <a href="orders.php">Volver</a>
    </form>

                    
    <script>
    function agregarPlato() {
        const container = document.getElementById('platos-container');
        const platosHTML = container.querySelector('.plato').cloneNode(true);
        container.appendChild(platosHTML);
    }
    </script>
    
</body>
</html>