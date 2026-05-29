<?php
header('Content-Type: application/json');

require_once 'db.php';

try {
    // luam toate inundatiile din tabel
    $sql = $pdo->prepare("SELECT * FROM INUNDATII");   
    
    $events = [];
    
    if ($sql->execute()) {
        while ($row = $sql->fetch()) {
            // formatam rezultatul pt frontend
            $event = [
                'id'       => $row['id_inundatie'],
                'type'     => 'inundatie',
                'title'    => $row['titlu'],
                'status'   => $row['status'],
                'location' => $row['locatie'],
                'details'  => $row['detalii'],
                'lat'      => $row['latitudine'],
                'lng'      => $row['longitudine']
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