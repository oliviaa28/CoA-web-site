<?php
header('Content-Type: application/json');

require_once 'db.php';

try {
    // luam toate cutremurele din tabel
    $sql = $pdo->prepare("SELECT * FROM INCIDENTE_CUTREMUR");   
    
    $events = [];
    
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            // formatam rezultatul pt frontend
           $event = [
                'id'             => $row['id_cutremur'], 
                'type'           => 'cutremur',
                'title'          => $row['titlu'],
                'status'         => $row['stadiu'],       
                'location'       => $row['localitate'],   
                'details'        => $row['descriere'],   
                'echipe_alocate' => $row['echipe_alocate'],
                'echipe_retrase' => $row['echipe_retrase'],
                'lat'            => $row['latitudine'],
                'lng'            => $row['longitudine'],
                'mag'            => $row['magnitudine'],
                'adancime'       => $row['adancime'],
                'arie'           => $row['arie'],
                'raza'           => $row['raza_afectata'],
                'instructiuni'   => $row['instructiuni'],
                'date'           => $row['data_incident'],
                'localitate'     => $row['localitate'],   
            ];

            $styles = getEventStyles($event['status']);
            $event['filtertype'] = $styles['filtertype'];
            $event['colorclass'] = $styles['colorclass'];
            $event['badgeclass'] = $styles['badgeclass'];
            
            $events[] = $event;
        }
    }
    echo json_encode($events);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>