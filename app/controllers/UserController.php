<?php 

require_once __DIR__ .  '/../../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController{
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new UserModel($pdo);
    }

    public function handleApiRequest(){

       header('Content-Type: application/json');
       $method = $_SERVER['REQUEST_METHOD'];

       switch($method) {
        case 'GET':

            try{
                $users = $this->model->getAllUsers();  //luam userii din bd
                echo json_encode($users);              // si ii trimitem in format json
            } catch (\PDOException $e){
                http_response_code(500);                //Internal Server Error
                echo json_encode( ['error' => $e->getMessage()] ); //trimitem eroarea ca json(fetch din js astaepta json)
            }
            break;

        case 'POST':
            $data = json_decode( file_get_contents('php://input'), true);
            $this->model->createUser($data);
            echo json_encode(['success' => true]);
            break;

        case 'PUT':
            $data = json_decode( file_get_contents('php://input'), true);
            $id = $data['id'];
            $this->model->updateUser($id, $data);
            echo json_encode(['success' => true]);
            break;
        
        case 'DELETE':
            $id = $_GET['id'];
            $this->model->deleteUser($id);
            echo json_encode(['success' => true ]);
                break;

        default:
             http_response_code(405);
             echo json_encode(['error' => 'Metoda nepermisa']);
             break;
        }
    }
}



?>