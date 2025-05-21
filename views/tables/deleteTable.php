<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();
$id = $_GET['id'] ?? null;

$message = '';

if ($id !== null) {
    // Verificar si la mesa está en uso
    if ($controller->isTableInUse($id)) {
        $message = "La mesa está en uso. No se puede eliminar hasta que todas las órdenes asociadas sean anuladas o completadas.";
    } else {
        // Si no está en uso, proceder con la eliminación
        $result = $controller->deleteTable($id);
        if ($result === "Mesa eliminada correctamente.") {
            $message = "La mesa ha sido eliminada exitosamente.";
        } else {
            $message = "No se pudo eliminar la mesa. Inténtalo nuevamente.";
        }
    }
} else {
    $message = "ID de mesa no proporcionado.";
}
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

    <p><?php echo $message; ?></p>

    <a href="restaurant_tables.php">Volver a las Mesas</a>
</body>
</html>