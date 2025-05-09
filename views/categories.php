<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/category.php';
include '../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller=new CategoriesController();
$categories=$controller->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>
<body>
    <h1>Categorias</h1>

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
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($categories as $category){
                    echo '<tr>';
                    echo '<td>'.$category->get('id').'</td>';
                    echo '<td>'.$category->get('name').'</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
        </tbody>
    </table>
</body>
</html>