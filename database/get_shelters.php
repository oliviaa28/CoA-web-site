<?php

header('Content-Type: application/json');

require_once 'db.php';

try {
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
    
    
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            
           
            $tip = strtolower($row['type']); 
            
         
            if (strpos($tip, 'medical') !== false || strpos($tip, 'ajutor') !== false) {
                $row['filtertype'] = 'medical';
                $row['colorclass'] = 'border-red';
                $row['badgeclass'] = 'bg-red';
            } 
           
            elseif (strpos($tip, 'buncar') !== false || strpos($tip, 'buncăr') !== false || strpos($tip, 'subteran') !== false) {
                $row['filtertype'] = 'buncar';
                $row['colorclass'] = 'border-orange';
                $row['badgeclass'] = 'bg-orange';
            } 
          
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