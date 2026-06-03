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
                    if ( isset($_GET['id']) ){ //daca avem in url si id ul, returnam un singur adapost
                        $shelter = $this->model->getShelterById($_GET['id']);
                        echo json_encode($shelter);
                    }
                    else {
                    $shelters = $this->model->getAllShelters();
                    echo json_encode($shelters);
                    }  
                }
                 catch (\PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $this->model->createShelter( $data); 
                echo json_encode(['success' => true ]);
                break;

            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);
                $id = $data['id'];
                $this->model->updateShelter($id, $data);
                echo json_encode(['success' => true]);
                break;

            case 'DELETE':
                $id = $_GET['id']; //numele parametrului din url 
                $this->model->deleteShelter($id);
                echo json_encode(['success' => true ]);
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Metodă nepermisă']);
                break;
        }
    }
}