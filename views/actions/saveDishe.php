<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/dishe.php';
include '../controllers/dishesController.php';

use app\controllers\DishesController;
$controller = new DishesController();
$result = empty($_POST['idInput'])
    ? $controller->saveNewDishe($_POST)
    : $controller->updateDishe($_POST);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la operación</title>
</head>
<body>
    <h1>Resultado de la operación</h1>
    <br>
    <?php
    if($result){
        echo '<p>Datos GUARDADOS</p>';
    }else{
        echo '<p>No se pudo GUARDAR los datos</p>';
    }   
    ?>
    <a href="dishes.php">Volver</a>
</body>
</html>