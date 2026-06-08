<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController{
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->model = new UserModel($pdo);
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=login');
            exit;
        }

        session_start();

        //preluam datele din formular 
        $email= $_POST['email_authority'];
        $password= $_POST['password_authority'];

        $user = $this->model->getUserByEmail($email);

        // Permitem autentificarea si daca parola este hash (password_verify) dar si daca este text simplu
        if( $user && (password_verify($password, $user['parola']) || $password === $user['parola']) ){
            $_SESSION['user_id']= $user['id_admin'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nume'] = $user['nume'];

            header('Location: index.php?route=events');
            exit;
        }else {
            header('Location: index.php?route=login&error=1');
            exit;
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
         }

        session_destroy();
        header('Location: index.php?route=events-public');
        exit;
    }

    public static function requireAuth() {
         if (session_status() === PHP_SESSION_NONE){
            session_start();
         }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
             exit;
        }
    }
}
?>