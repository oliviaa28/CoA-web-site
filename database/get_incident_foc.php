<?php
header('Content-Type: application/json');

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
    
    // extragem inregistrarile
    $sql = $pdo->prepare("SELECT * FROM INCENDII");   
    
    $events = [];
    
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            $status = strtolower($row['status']); 
            
            // mapare date pt front-end
            $event = [
                'id'       => $row['id_incendiu'], 
                'title'    => $row['titlu'],
                'status'   => $row['status'],
                'location' => $row['locatie'],
                'details'  => $row['detalii'],
                'lat'      => $row['latitudine'],
                'lng'      => $row['longitudine']
            ];

            // stilizare card dupa status
            if (strpos($status, 'activ') !== false) {
                $event['filtertype'] = 'activ';
                $event['colorclass'] = 'border-red';
                $event['badgeclass'] = 'bg-red';
            } elseif (strpos($status, 'monitorizare') !== false) {
                $event['filtertype'] = 'monitorizare';
                $event['colorclass'] = 'border-orange';
                $event['badgeclass'] = 'bg-orange';
            } else {
                $event['filtertype'] = 'rezolvat';
                $event['colorclass'] = 'border-teal';
                $event['badgeclass'] = 'bg-teal';
            }
            $events[] = $event;
        }
    }
    echo json_encode($events);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>