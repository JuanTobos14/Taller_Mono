<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$tableController = new TablesController();
$tables = $tableController->queryAllTables();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Mesas</h1>

        <div class="menu">
            <a href="../../index.html">Pag. Principal</a>
            <a href="../categories/categories.php">Categorías</a>
            <a href="../dishes/dishes.php">Platos</a>
            <a href="../orders/orders.php">Ordenes</a>
        </div>

        <a href="form_table.php" class="add-link">Registrar nueva mesa</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?= $table->get('id') ?></td>
                        <td><?= $table->get('name') ?></td>
                        <td>
                            <a href="form_table.php?id=<?= $table->get('id') ?>" class="button modify">Modificar</a>
                            <a href="deleteTable.php?id=<?= $table->get('id') ?>" class="button delete" onclick="return confirm('¿Estás seguro de que deseas eliminar esta mesa?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
