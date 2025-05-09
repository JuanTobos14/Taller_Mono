<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/dishe.php';
include '../controllers/dishesController.php';

use app\controllers\DishesController;

$controller=new DishesController();
$dishes=$controller->queryAllDishes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
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
            <?php
                foreach($dishes as $dishe){
                    echo '<tr>';
                    echo '<td>'.$dishe->get('id').'</td>';
                    echo '<td>'.$dishe->get('description').'</td>';
                    echo '<td>'.$dishe->get('price').'</td>';
                    echo '<td>'.$dishe->get('idCategory').'</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
        </tbody>
    </table>
</body>
</html>