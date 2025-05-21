<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();

$id = '';
$name = '';

if (!empty($_GET['id'])) {
    $table = $controller->queryTableById($_GET['id']);
    if ($table) {
        $id = $table->get('id');
        $name = $table->get('name');
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= empty($id) ? 'Registrar nueva mesa' : 'Modificar mesa' ?></title>
</head>
<body>
    <h1><?= empty($id) ? 'Registrar nueva mesa' : 'Modificar mesa' ?></h1>

    <form action="saveTable.php" method="POST">
        <?php if (!empty($id)): ?>
            <input type="hidden" name="idInput" value="<?= $id ?>">
        <?php endif; ?>

        <label for="nameInput">Nombre de la Mesa:</label>
        <input type="text" name="nameInput" id="nameInput" required value="<?= $name ?>"><br><br>

        <button type="submit">Guardar</button>
    </form>

    <a href="restaurant_tables.php">Volver</a>
</body>
</html>