<?php
// config/database.php

$host = 'localhost';
$port = '1521';
$db   = 'xe';           
$user = 'CoA';          
$pass = 'CoA_admin';    

$dsn = "oci:dbname=//$host:$port/$db;charset=AL32UTF8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_CASE               => PDO::CASE_LOWER, 
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    header('Content-Type: application/json');
    die(json_encode(['error' => 'Eroare la conectarea cu baza de date: ' . $e->getMessage()]));
}