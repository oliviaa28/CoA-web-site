<?php
require_once '../../../database/db.php';

// Preluăm ID-ul și TIPUL din URL (ex: details_public.php?id=2&type=cutremur)
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$eventType = isset($_GET['type']) ? $_GET['type'] : '';

$event = null;

if ($eventId > 0 && $eventType) {
    // Mapăm tipurile de culori exact ca în array-ul vechi
    $colorMap = [
        'activ' => 'var(--color-activ)', 
        'monitorizare' => 'var(--color-monotorizare)', 
        'rezolvat' => 'var(--color-rezolvat)'
    ];

    if ($eventType === 'cutremur') {
        $stmt = $pdo->prepare("SELECT * FROM INCIDENTE_CUTREMUR WHERE id_cutremur = :id");
        $stmt->execute(['id' => $eventId]);
        if ($row = $stmt->fetch()) {
            $styles = getEventStyles($row['stadiu']);
            $event = [
                'title' => $row['titlu'],
                'status' => strtoupper($row['stadiu']),
                'badge' => $styles['badgeclass'],
                'color' => $colorMap[$styles['filtertype']] ?? 'var(--text-main)',
                'date' => $row['data_incident'] ?? 'Dată necunoscută',
                'lat' => $row['latitudine'],
                'lng' => $row['longitudine'],
                'epicenter' => $row['localitate'] ?? 'Necunoscut',
                'stat1_label' => 'Magnitudine', 'stat1_val' => ($row['magnitudine'] ?? '-') . ' Mw',
                'stat2_label' => 'Adâncime', 'stat2_val' => ($row['adancime'] ?? '-') . ' km',
                'stat3_label' => 'Echipe Alocate', 'stat3_val' => $row['echipe_alocate'] ?? '0',
                'instruction' => $row['instructiuni'] ?? 'Urmați indicațiile autorităților.',
                'description' => $row['descriere'] ?? 'Fără descriere.'
            ];
        }
    } elseif ($eventType === 'inundatie') {
        $stmt = $pdo->prepare("SELECT * FROM INCIDENTE_INUNDATIE WHERE id_inundatie = :id");
        $stmt->execute(['id' => $eventId]);
        if ($row = $stmt->fetch()) {
            $styles = getEventStyles($row['status']);
            $event = [
                'title' => $row['titlu'],
                'status' => strtoupper($row['status']),
                'badge' => $styles['badgeclass'],
                'color' => $colorMap[$styles['filtertype']] ?? 'var(--text-main)',
                'date' => 'Dată necunoscută',
                'lat' => $row['latitudine'],
                'lng' => $row['longitudine'],
                'epicenter' => $row['locatie'] ?? 'Necunoscut',
                'stat1_label' => 'Statut', 'stat1_val' => 'În desfășurare',
                'stat2_label' => 'Victime', 'stat2_val' => '-',
                'stat3_label' => 'Echipe', 'stat3_val' => '-',
                'instruction' => $row['detalii'] ?? 'Evitați zonele inundabile.',
                'description' => $row['detalii'] ?? 'Fără descriere.'
            ];
        }
    } elseif ($eventType === 'incendiu') {
        $stmt = $pdo->prepare("SELECT * FROM INCIDENTE_FOC WHERE id_incendiu = :id");
        $stmt->execute(['id' => $eventId]);
        if ($row = $stmt->fetch()) {
            $styles = getEventStyles($row['status']);
            $event = [
                'title' => $row['titlu'],
                'status' => strtoupper($row['status']),
                'badge' => $styles['badgeclass'],
                'color' => $colorMap[$styles['filtertype']] ?? 'var(--text-main)',
                'date' => 'Dată necunoscută',
                'lat' => $row['latitudine'],
                'lng' => $row['longitudine'],
                'epicenter' => $row['locatie'] ?? 'Necunoscut',
                'stat1_label' => 'Suprafață', 'stat1_val' => 'Necunoscută',
                'stat2_label' => 'Focare', 'stat2_val' => '-',
                'stat3_label' => 'Echipe', 'stat3_val' => '-',
                'instruction' => $row['detalii'] ?? 'Nu vă apropiați de zonele afectate.',
                'description' => $row['detalii'] ?? 'Fără descriere.'
            ];
        }
    }
}

// Dacă nu găsim evenimentul în baza de date (ID greșit sau a fost șters), oprim afișarea și dăm mesaj
if (!$event) {
    die("<div style='padding: 3rem; text-align: center; font-family: sans-serif;'><h2>Evenimentul nu a fost găsit!</h2><br><a href='/CoA-project/app/views/public/events_public.php'>← Înapoi la hartă</a></div>");
}
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Eveniment - CoA</title>

    <!-- CSS Global și CSS specific detaliilor publice -->
    <link rel="stylesheet" href="/CoA-project/public/css/global.css">
    <link rel="stylesheet" href="/CoA-project/public/css/details-public.css">

    <!-- Leaflet.js CSS pentru hartă -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body>
    <?php
    $active_page = 'events';
    include '../layouts/header.php';
    ?>

    <!-- Container principal (centrat) -->
    <div style="padding: 2rem; max-width: 1200px; margin: 0 auto; width: 100%;">
        
        <!-- Buton de înapoi -->
        <nav class="inapoi-btn">
            <a href="/CoA-project/app/views/public/events_public.php">← Înapoi la Evenimente</a>
        </nav>

        <!-- Header eveniment -->
        <div class="event-detail-header" style="margin-top: 1rem;">
            <div class="event-detail-left">
                <span class="badge <?php echo $event['badge']; ?>"><?php echo $event['status']; ?></span>
                <h1 style="margin: 0.5rem 0; color: var(--text-main);"><?php echo $event['title']; ?></h1>
                <p class="current-date" style="color: var(--text-muted); margin: 0;"><?php echo $event['date']; ?></p>
            </div>
        </div>

        <!-- Carduri statistice -->
        <div class="status-cards" style="margin-bottom: 2rem;">
            <div class="status-card dark">
                <span class="status-label"><?php echo $event['stat1_label']; ?></span>
                <span class="status-number"><?php echo $event['stat1_val']; ?></span>
            </div>
            <div class="status-card dark">
                <span class="status-label"><?php echo $event['stat2_label']; ?></span>
                <span class="status-number"><?php echo $event['stat2_val']; ?></span>
            </div>
            <div class="status-card dark">
                <span class="status-label"><?php echo $event['stat3_label']; ?></span>
                <span class="status-number"><?php echo $event['stat3_val']; ?></span>
            </div>
        </div>

        <!-- Harta + paneluri detalii -->
        <div class="event-detail-body" style="flex-wrap: wrap;">

            <!-- Harta -->
            <div class="event-map" id="detail-map" style="min-height: 400px; z-index: 1;">
                <div class="map-footer" style="z-index: 999;">
                    <span>📍 Epicentru estimat - <?php echo $event['epicenter']; ?></span>
                </div>
            </div>

            <!-- Paneluri dreapta -->
            <div class="event-detail-panels">
                <div class="detail-panel cap-panel" style="border-left-color: <?php echo $event['color']; ?>;">
                    <h3>Instrucțiuni pentru populație</h3>
                    <p style="color: var(--text-muted); line-height: 1.5; font-size: 0.95rem;">
                        <?php echo $event['instruction']; ?>
                    </p>
                </div>

                <div class="detail-panel">
                    <h3>Descriere</h3>
                    <p style="color: var(--text-muted); line-height: 1.5; font-size: 0.95rem;">
                        <?php echo $event['description']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Harta Leaflet pentru detalii
        var map = L.map('detail-map').setView([<?php echo $event['lat']; ?>, <?php echo $event['lng']; ?>], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        var marker = L.marker([<?php echo $event['lat']; ?>, <?php echo $event['lng']; ?>]).addTo(map);
        marker.bindPopup("<b><?php echo $event['title']; ?></b><br><?php echo $event['epicenter']; ?>, România").openPopup();
    </script>
    <script src="/CoA-project/public/js/main.js"></script>
</body>
</html>