<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/AlertModel.php';

class AlertController{

    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new AlertModel($pdo);
    }

    
     public function handleApiRequest() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                try {
                    if ( isset($_GET['id_incident']) && isset($_GET['tip_incident']) ) {
                        // alertele unui eveniment
                        $alerts= $this->model->getAlertsByEvent($_GET['id_incident'], $_GET['tip_incident']);
                        echo json_encode($alerts);
                     } else
                      if ( isset($_GET['id']) ) {
                            // o singura alerta (pentru cap-details)
                         $alert = $this->model->getAlertById($_GET['id']);
                         echo json_encode($alert);}
                     else {
                         // toate alertele
                         $alerts = $this->model->getAllAlerts();
                         echo json_encode($alerts);
                     }
                } 
                catch (\PDOException $e) {
                    http_response_code(500);
                    echo json_encode( ['error' => $e->getMessage()] );
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $this->model->createAlert($data);
                echo json_encode(['success' => true]);
                break;

            case 'DELETE':
                $id = $_GET['id'];
                $this->model->deleteAlert($id);
                echo json_encode(['success' => true]);
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Metoda nepermisa']);
                break;
        }
     }


    
}

?>