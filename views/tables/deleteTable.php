<?php
include '../../models/drivers/conexDB.php';
include '../../models/entities/entity.php';
include '../../models/entities/restaurant_table.php';
include '../../controllers/tablesController.php';

use app\controllers\TablesController;

$controller = new TablesController();
$id = $_GET['id'];  // Obtenemos el id de la mesa desde la URL

// Verificar si la mesa está en uso
if ($controller->isTableInUse($id)) {
    // Si está en uso, mostrar el mensaje y no eliminarla
    echo "<p>La mesa está en uso. No se puede eliminar hasta que todas las órdenes asociadas sean anuladas o completadas.</p>";
} else {
    // Si no está en uso, proceder con la eliminación
    $result = $controller->deleteTable($id);

    if ($result == "Mesa eliminada correctamente.") {
        echo "<p>La mesa ha sido eliminada exitosamente.</p>";
    } else {
        echo "<p>No se pudo eliminar la mesa. Inténtalo nuevamente.</p>";
    }
}
?>

<a href="restaurant_tables.php">Volver a las Mesas</a>