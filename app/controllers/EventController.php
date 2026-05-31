<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/EventModel.php';

class EventController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new EventModel($pdo);
    }

    public function handleApiRequest() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $type = $_GET['type'] ?? 'all';
                try {
                    $events = $this->model->getAllEvents($type);
                    echo json_encode($events);
                } catch (\PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            case 'POST':
                echo json_encode(['message' => 'Endpoint POST pregătit pentru adăugare']);
                break;
            case 'PUT':
                echo json_encode(['message' => 'Endpoint PUT pregătit pentru actualizare']);
                break;
            case 'DELETE':
                echo json_encode(['message' => 'Endpoint DELETE pregătit pentru ștergere']);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Metodă nepermisă']);
                break;
        }
    }

    public function showDetails($id, $type) {
        $row = $this->model->getEventDetails($id, $type);
        
        $event = null;
        if ($row) {
            $event = $this->formatEventData($row, $type);
        }
        
        // Flag pentru a permite rularea view-ului pur
        $is_included = true;
        
        if (!$event) {
            die("<div style='padding: 3rem; text-align: center; font-family: sans-serif;'><h2>Evenimentul nu a fost găsit!</h2><br><a href='events_public.php'>← Înapoi la hartă</a></div>");
        }

        // Includem View-ul care doar afișează HTML (folosim require, nu require_once)
        require __DIR__ . '/../views/public/details_public.php';
    }

    private function formatEventData($row, $type) {
        $status = strtolower($row['stadiu'] ?? '');
        $styles = $this->getEventStyles($status);
        
        $colorMap = [
            'activ' => 'var(--color-activ)', 
            'monitorizare' => 'var(--color-monotorizare)', 
            'rezolvat' => 'var(--color-rezolvat)'
        ];

        $event = [
            'title' => $row['titlu'],
            'status' => strtoupper($status),
            'badge' => $styles['badgeclass'],
            'color' => $colorMap[$styles['filtertype']] ?? 'var(--text-main)',
            'date' => $row['data_incident'] ?? 'Dată necunoscută',
            'lat' => $row['latitudine'],
            'lng' => $row['longitudine'],
        ];

        if ($type === 'cutremur') {
            $event['epicenter'] = $row['localitate'] ?? 'Necunoscut';
            $event['stat1_label'] = 'Magnitudine'; $event['stat1_val'] = ($row['magnitudine'] ?? '-') . ' Mw';
            $event['stat2_label'] = 'Adâncime'; $event['stat2_val'] = ($row['adancime'] ?? '-') . ' km';
            $event['stat3_label'] = 'Echipe Alocate'; $event['stat3_val'] = $row['echipe_alocate'] ?? '0';
            $event['instruction'] = $row['instructiuni'] ?? 'Urmați indicațiile autorităților.';
            $event['description'] = $row['descriere'] ?? 'Fără descriere.';
            
        } elseif ($type === 'inundatie') {
            $event['epicenter'] = $row['localitate'] ?? 'Necunoscut';
            $event['stat1_label'] = 'Nivel Apă'; $event['stat1_val'] = ($row['nivel_apa'] ?? '-') . ' cm';
            $event['stat2_label'] = 'Debit'; $event['stat2_val'] = ($row['debit'] ?? '-') . ' mc/s';
            $event['stat3_label'] = 'Zone Afectate'; $event['stat3_val'] = $row['zone_afectate'] ?? '0';
            $event['instruction'] = $row['instructiuni'] ?? 'Evitați zonele inundate și urmați instrucțiunile.';
            $event['description'] = $row['descriere'] ?? 'Fără descriere.';
        } else {
            // Pentru incendii (dacă nu au încă un set complet de coloane)
            $event['epicenter'] = $row['localitate'] ?? 'Necunoscut';
            $event['stat1_label'] = 'Suprafață'; $event['stat1_val'] = 'Necunoscută';
            $event['stat2_label'] = 'Focare'; $event['stat2_val'] = '-';
            $event['stat3_label'] = 'Echipe'; $event['stat3_val'] = '-';
            $event['instruction'] = $row['descriere'] ?? 'Evitați zonele afectate.';
            $event['description'] = $row['descriere'] ?? 'Fără descriere.';
        }

        return $event;
    }

    private function getEventStyles($status) {
        $status = strtolower($status);
        if (strpos($status, 'activ') !== false) {
            return ['filtertype' => 'activ', 'colorclass' => 'border-red', 'badgeclass' => 'bg-red'];
        } elseif (strpos($status, 'monitorizare') !== false) {
            return ['filtertype' => 'monitorizare', 'colorclass' => 'border-orange', 'badgeclass' => 'bg-orange'];
        } else {
            return ['filtertype' => 'rezolvat', 'colorclass' => 'border-teal', 'badgeclass' => 'bg-teal'];
        }
    }
}