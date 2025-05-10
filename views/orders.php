<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/restaurant_table.php';
include '../models/entities/dish.php';
include '../controllers/tablesController.php';
include '../controllers/dishesController.php';

use app\controllers\TablesController;
use app\controllers\DishesController;

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
    <title>Registrar Orden</title>
</head>
<body>
    <h1>Registrar Orden</h1>
    <form action="save_order.php" method="POST">
        <label for="dateOrderInput">Fecha de la Orden:</label>
        <input type="date" name="dateOrderInput" id="dateOrderInput" required><br><br>

        <label for="idTableInput">Mesa:</label>
        <select name="idTableInput" id="idTableInput" required>
            <?php foreach ($tables as $table): ?>
                <option value="<?= $table->get('id') ?>"><?= $table->get('name') ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <h3>Platos:</h3>
        <table>
            <thead>
                <tr>
                    <th>Plato</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dishes as $dishe): ?>
                    <tr>
                        <td><?= $dishe->get('description') ?></td>
                        <td><input type="number" name="quantities[<?= $dish->get('id') ?>]" value="1" min="1"></td>
                        <td><?= $dishe->get('price') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>

        <button type="submit">Registrar Orden</button>
    </form>
</body>
</html>
