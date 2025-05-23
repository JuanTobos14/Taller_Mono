<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/dishe.php';
include '../../controllers/dishesController.php';

use app\controllers\DishesController;

$controller = new DishesController();
$dishes = $controller->queryAllDishes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
        <h1>Platos</h1>

        <div class="menu">
            <a href="../../index.html">Pag. Principal</a>
            <a href="../categories/categories.php">Categorías</a>
            <a href="../orders/orders.php">Ordenes</a>
            <a href="../tables/restaurant_tables.php">Mesas</a>
        </div>

        <a href="form_dishe.php" class="add-link">Registrar nuevo plato</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dishes as $dishe): ?>
                    <tr>
                        <td><?= $dishe->get('id') ?></td>
                        <td><?= $dishe->get('description') ?></td>
                        <td><?= $dishe->get('price') ?></td>
                        <td><?= $dishe->get('idCategory') ?></td>
                        <td>
                            <a href="form_dishe.php?id=<?= $dishe->get('id') ?>" class="button modify">Modificar</a>
                            <a href="deleteDishe.php?id=<?= $dishe->get('id') ?>" class="button delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este plato?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
