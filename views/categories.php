<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/category.php';
include '../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();
$categories = $controller->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>
<body>
    <h1>Categorías</h1>

    <div class="menu">
        <a href="categories.php">Categorías</a>
        <a href="dishes.php">Platos</a>
        <a href="orders.php">Ordenes</a>
        <a href="order_details.php">Detalles Orden</a>
        <a href="restaurant_tables.php">Mesas</a>
    </div>

    <a href="form_category.php">Registrar nueva categoría</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category->get('id') ?></td>
                    <td><?= $category->get('name') ?></td>
                    <td>
                        <a href="form_category.php?id=<?= $category->get('id') ?>">Modificar</a>
                        <a href="actions/deleteCategory.php?id=<?= $category->get('id') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
