<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/ShelterModel.php';

class ShelterController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new ShelterModel($pdo);
    }

    public function handleApiRequest() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                try {
                    $shelters = $this->model->getAllShelters();
                    echo json_encode($shelters);
                } catch (\PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            case 'POST':
                echo json_encode(['message' => 'Endpoint POST pregătit pentru adăugare adăpost']);
                break;
            case 'PUT':
                echo json_encode(['message' => 'Endpoint PUT pregătit pentru actualizare adăpost']);
                break;
            case 'DELETE':
                echo json_encode(['message' => 'Endpoint DELETE pregătit pentru ștergere adăpost']);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Metodă nepermisă']);
                break;
        }
    }
}