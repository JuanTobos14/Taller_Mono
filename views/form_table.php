<?php
include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/restaurant_table.php';
include '../controllers/tablesController.php';

use app\controllers\TablesController;

$id = '';
$name = '';

if (!empty($_GET['id'])) {
    $controller = new TablesController();
    $tables = $controller->queryAllTables();

    foreach ($tables as $table) {
        if ($table->get('id') == $_GET['id']) {
            $id = $table->get('id');
            $name = $table->get('name');
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
    <title><?= empty($id) ? 'Registrar' : 'Modificar' ?> Mesa</title>
</head>
<body>
    <h1><?= empty($id) ? 'Registrar nueva mesa' : 'Modificar mesa' ?></h1>

    <form action="saveTable.php" method="post">
        <?php if (!empty($id)): ?>
            <input type="hidden" name="idInput" value="<?= $id ?>">
        <?php endif; ?>

        <div>
            <label>Nombre de la mesa:</label>
            <input type="text" name="nameInput" required value="<?= $name ?>">
        </div>

        <div>
            <button type="submit">Guardar</button>
        </div>

        <a href="restaurant_tables.php">Volver</a>
    </form>
</body>
</html>