<?php

header('Content-Type: application/json');

// Configurare pentru Oracle DB
$host = 'localhost';
$port = '1521';
$db   = 'xe';           // Baza de date (SID/Service Name). De obicei este 'xe' sau 'orcl'
$user = 'CoA';          // Numele de utilizator din baza de date Oracle
$pass = 'CoA_admin';    // Parola

// Conexiune PDO pentru Oracle
$dsn = "oci:dbname=//$host:$port/$db;charset=AL32UTF8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_CASE               => PDO::CASE_LOWER, // Forțează cheile coloanelor să fie cu litere mici
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Pregătirea interogării (Prepared Statements)
 $sql = $pdo->prepare('SELECT 
    ID_ADAPOST AS "id",
    TIP AS "type",
    NUME AS "name",
    ADRESA AS "address",
    DESCRIERE AS "details",
    LATITUDINE AS "lat",
    LONGITUDINE AS "lng"
FROM ADAPOSTURI');   
$shelters = [];
    
    // Executarea și preluarea (fetching) rând cu rând
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            
            // Generăm dinamic culorile și filtrele în funcție de tipul adăpostului
            $tip = strtolower($row['type']); // Transformăm tipul în litere mici pentru verificare
            
            // Dacă tipul conține "medical" sau "ajutor", îi punem design roșu
            if (strpos($tip, 'medical') !== false || strpos($tip, 'ajutor') !== false) {
                $row['filtertype'] = 'medical';
                $row['colorclass'] = 'border-red';
                $row['badgeclass'] = 'bg-red';
            } 
            // Dacă e buncăr, îi punem design portocaliu
            elseif (strpos($tip, 'buncar') !== false || strpos($tip, 'buncăr') !== false || strpos($tip, 'subteran') !== false) {
                $row['filtertype'] = 'buncar';
                $row['colorclass'] = 'border-orange';
                $row['badgeclass'] = 'bg-orange';
            } 
            // Pentru restul (ex: provizii), îi punem design verde
            else {
                $row['filtertype'] = 'provizii';
                $row['colorclass'] = 'border-teal';
                $row['badgeclass'] = 'bg-teal';
            }

            $shelters[] = $row;
        }
    }

    // Returnăm datele în format JSON
    echo json_encode($shelters);
    
} catch (\PDOException $e) {
    
    echo json_encode(['error' => $e->getMessage()]);
}
?>