<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/dishe.php';
include '../models/entities/category.php';
include '../controllers/dishesController.php';
include '../controllers/categoriesController.php';

use app\controllers\DishesController;
use app\controllers\CategoriesController;

$controller = new DishesController();
$dishes = $controller->queryAllDishes();

$categoriesController = new CategoriesController();
$categories = $categoriesController->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
</head>
<body>
    <h1>Platos</h1>

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
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            <a href="form_dishe.php">Registrar nuevo plato</a>
            <?php foreach ($dishes as $dishe): ?>
                <tr>
                    <td><?= $dishe->get('id') ?></td>
                    <td><?= $dishe->get('description') ?></td>
                    <td><?= $dishe->get('price') ?></td>
                    <td><?= $dishe->get('idCategory') ?></td>
                    <td>
                        <a href="form_dishe.php?id=<?= $dishe->get('id') ?>">Modificar</a>
                        <a href="deleteCategory.php?id=<?= $category->get('id') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
