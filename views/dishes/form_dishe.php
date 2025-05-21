<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/dishe.php';
include '../../models/entities/category.php';
include '../../controllers/dishesController.php';
include '../../controllers/categoriesController.php';

use app\controllers\DishesController;

$controller = new DishesController();

$id = '';
$description = '';
$price = '';
$idCategory = '';

// Obtener el plato si se está editando
if (!empty($_GET['id'])) {
    $dishes = $controller->queryAllDishes();
    foreach ($dishes as $dishe) {
        if ($dishe->get('id') == $_GET['id']) {
            $id = $dishe->get('id');
            $description = $dishe->get('description');
            $price = $dishe->get('price');
            $idCategory = $dishe->get('idCategory');
            break;
        }
    }
}

// Obtener todas las categorías
$categories = $controller->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($id) ? 'Registrar' : 'Modificar' ?> Plato</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container">
        <h1><?= empty($id) ? 'Registrar nuevo plato' : 'Modificar plato' ?></h1>

        <form action="saveDishe.php" method="post">
            <?php if (!empty($id)): ?>
                <input type="hidden" name="idInput" value="<?= $id ?>">
            <?php endif; ?>

            <div>
                <label>Descripción del Plato:</label>
                <input type="text" name="descriptionInput" required value="<?= $description ?>">
            </div>

            <div>
                <label>Precio:</label>
                <input type="number" name="priceInput" required value="<?= $price ?>" step="0.01">
            </div>

            <div>
                <label>Categoría:</label>
                <?php if (!empty($id)): ?>
                    <!-- Si estamos editando, mostramos el nombre de la categoría -->
                    <?php
                    // Buscar el nombre de la categoría a partir del idCategory
                    $categoryName = '';
                    foreach ($categories as $category) {
                        if ($category->get('id') == $idCategory) {
                            $categoryName = $category->get('name');
                            break;
                        }
                    }
                    ?>
                    <span><?= $categoryName ?></span> <!-- Muestra el nombre de la categoría como texto -->
                    <input type="hidden" name="idCategoryInput" value="<?= $idCategory ?>"> <!-- Envía el idCategory al servidor -->
                <?php else: ?>
                    <!-- Si no estamos editando, mostramos el select -->
                    <select name="idCategoryInput">
                        <option value="">Seleccione una categoría</option>
                        <?php
                        // Asegúrate de que $categories no esté vacío
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                echo "<option value='" . $category->get('id') . "' " . 
                                     ($idCategory == $category->get('id') ? 'selected' : '') . ">" . 
                                     $category->get('name') . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay categorías disponibles</option>";
                        }
                        ?>
                    </select>
                <?php endif; ?>
            </div>

            <div>
                <button type="submit">Guardar</button>
            </div>

            <a href="dishes.php" class="add-link">Volver</a>
        </form>
    </div>
</body>
</html>
