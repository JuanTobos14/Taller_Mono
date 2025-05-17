<?php
header("Content-Type: application/json");

include '../models/drivers/conexDB.php';
include '../models/entities/entity.php';
include '../models/entities/category.php';
include '../controllers/categoriesController.php';

use app\controllers\CategoriesController;

$controller = new CategoriesController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $categories = $controller->queryAllCategories();
        $data = [];
        foreach ($categories as $cat) {
            $data[] = [
                'id' => $cat->get('id'),
                'name' => $cat->get('name')
            ];
        }
        echo json_encode($data);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nameInput'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el campo nameInput']);
            break;
        }

        $result = $controller->saveNewCategory($data);
        echo json_encode(['success' => $result]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
