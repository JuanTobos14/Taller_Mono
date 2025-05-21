<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

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
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
            <h1>Categorías</h1>

        <div class="menu">
            <a href="../../index.html">Pag. Principal</a>
            <a href="../dishes/dishes.php">Platos</a>
            <a href="../orders/orders.php">Ordenes</a>
            <a href="../tables/restaurant_tables.php">Mesas</a>
        </div>

        <a class="add-link" href="form_category.php">Registrar nueva categoría</a>

        <?php if (isset($_GET['result'])): ?>
            <p>
                <?= ($_GET['result'] === 'success') ? 'Operación realizada con éxito.' : 'Error al realizar la operación.' ?>
            </p>
        <?php endif; ?>

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
                            <a class="modify" href="form_category.php?id=<?= $category->get('id') ?>">Modificar</a>
                            <a class="delete" href="deleteCategory.php?id=<?= $category->get('id') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
