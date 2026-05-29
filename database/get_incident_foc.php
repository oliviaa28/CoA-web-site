<?php
header('Content-Type: application/json');

require_once 'db.php';

try {
    // extragem inregistrarile
    $sql = $pdo->prepare("SELECT * FROM INCIDENTE_FOC");   
    
    $events = [];
    
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            // mapare date pt front-end
            $event = [
                'id'             => $row['id_foc'], 
                'type'           => 'incendiu',
                'title'          => $row['titlu'],
                'echipe_alocate' => $row['echipe_alocate'],
                'echipe_retrase' => $row['echipe_retrase'],
                'severitate'     => $row['severitate'],
                'location'       => $row['localitate'],
                'instructiuni'   => $row['instructiuni'],
                'descriere'      => $row['descriere'],
                'date'           => $row['data_incident'],
                'details'        => $row['detalii'],
                'status'         => $row['stadiu'],
                'lat'            => $row['latitudine'],
                'lng'            => $row['longitudine']
            ];

            $styles = getEventStyles($row['status']);
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