<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/dishe.php';
include '../models/entities/category.php';
include '../controllers/dishesController.php';
include '../controllers/categoriesController.php';

use app\controllers\DishesController;
use app\controllers\CategoriesController;

$description = '';
$price = '';
$idCategory = '';
$categoryName = '';
$isEditing = !empty($_GET['id']);

if ($isEditing) {
    $dishesController = new DishesController();
    $dishes = $dishesController->queryAllDishes();
    foreach ($dishes as $d) {
        if ($d->get('id') == $_GET['id']) {
            $description = $d->get('description');
            $price = $d->get('price');
            $idCategory = $d->get('idCategory');
            break;
        }
    }

    // Obtener nombre de la categoría asociada
    $categoriesController = new CategoriesController();
    $categories = $categoriesController->queryAllCategories();
    foreach ($categories as $cat) {
        if ($cat->get('id') == $idCategory) {
            $categoryName = $cat->get('name');
            break;
        }
    }
} else {
    $categoriesController = new CategoriesController();
    $categories = $categoriesController->queryAllCategories();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
</head>
<body>
    <h1><?= $isEditing ? 'Modificar plato' : 'Registrar nuevo plato'; ?></h1>
    <br>
    <form action="saveDishe.php" method="post">
        <?php if ($isEditing): ?>
            <input type="hidden" name="idInput" value="<?= $_GET['id'] ?>">
        <?php endif; ?>

        <div>
            <label>Descripción:</label>
            <input type="text" name="descriptionInput" required value="<?= $description ?>">
        </div>

        <div>
            <label>Precio:</label>
            <input type="text" name="priceInput" required value="<?= $price ?>">
        </div>

        <?php if (!$isEditing): ?>
            <div>
                <label>Categoría:</label>
                <select name="idCategory" required>
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->get('id') ?>">
                            <?= $category->get('name') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php else: ?>
            <input type="hidden" name="idCategory" value="<?= $idCategory ?>">
            <div>
                <label>Categoría:</label>
                <span><?= $categoryName ?></span>
            </div>
        <?php endif; ?>

        <div>
            <button type="submit">Guardar</button>
        </div>

        <a href="dishes.php">Volver</a>
    </form>
</body>
</html>
