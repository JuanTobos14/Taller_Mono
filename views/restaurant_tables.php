<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/restaurant_table.php';
include '../controllers/tablesController.php';

use app\controllers\TablesController;

$controller=new TablesController();
$tables=$controller->queryAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>
<body>
    <h1>Mesas</h1>

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
                foreach($tables as $table){
                    echo '<tr>';
                    echo '<td>'.$table->get('id').'</td>';
                    echo '<td>'.$table->get('name').'</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
        </tbody>
    </table>
</body>
</html>