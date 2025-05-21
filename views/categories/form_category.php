<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/category.php';
include '../../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();

$id = '';
$name = '';

if (!empty($_GET['id'])) {
    $categories = $controller->queryAllCategories();
    foreach ($categories as $category) {
        if ($category->get('id') == $_GET['id']) {
            $id = $category->get('id');
            $name = $category->get('name');
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($id) ? 'Registrar' : 'Modificar' ?> Categoría</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <h1><?= empty($id) ? 'Registrar nueva categoría' : 'Modificar categoría' ?></h1>

    <form action="saveCategory.php" method="post">
        <?php if (!empty($id)): ?>
            <input type="hidden" name="idInput" value="<?= $id ?>">
        <?php endif; ?>

        <div>
            <label>Nombre de la Categoría:</label>
            <input type="text" name="nameInput" required value="<?= $name ?>">
        </div>

        <div>
            <button class="add-link" type="submit">Guardar</button>
        </div>

        <a class="add-link" href="categories.php">Volver</a>
    </form>
</body>
</html>
