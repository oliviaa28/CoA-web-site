<?php
// date conectare db
$host = 'localhost';
$port = '1521';
$db   = 'xe';           
$user = 'CoA';          
$pass = 'CoA_admin';    

// initializare pdo
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
    echo json_encode(['error' => 'Eroare la conectarea cu baza de date: ' . $e->getMessage()]);
    exit;
}

// Funcție de utilitate pentru a seta culorile în funcție de status (folosită de incidente)
function getEventStyles($status) {
    $status = strtolower($status);
    if (strpos($status, 'activ') !== false) {
        return ['filtertype' => 'activ', 'colorclass' => 'border-red', 'badgeclass' => 'bg-red'];
    } elseif (strpos($status, 'monitorizare') !== false) {
        return ['filtertype' => 'monitorizare', 'colorclass' => 'border-orange', 'badgeclass' => 'bg-orange'];
    } else {
        return ['filtertype' => 'rezolvat', 'colorclass' => 'border-teal', 'badgeclass' => 'bg-teal'];
    }
}
?>