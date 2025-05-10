<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/restaurant_table.php';
include '../controllers/tablesController.php';

use app\controllers\TablesController;

$controller=new TablesController();
$tables=$controller->queryAllTables();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>
<body>
    <h1>Mesas</h1>

    <div class="menu">
        <a href="categories.php">Categorías</a>
        <a href="dishes.php">Platos</a>
        <a href="orders.php">Ordenes</a>
        <a href="order_details.php">Detalles Orden</a>
        <a href="restaurant_tables.php">Mesas</a>
    </div>
    <a href="form_table.php">Registrar nueva mesa</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tables as $table): ?>
                <tr>
                    <td><?= $table->get('id') ?></td>
                    <td><?= $table->get('name') ?></td>
                    <td>
                        <a href="form_table.php?id=<?= $table->get('id') ?>">Modificar</a>
                        <a href="deleteTable.php?id=<?= $table->get('id') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta mesa?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>