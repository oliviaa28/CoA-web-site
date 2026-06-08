<?php
if (!isset($is_included)) {
    // Dacă fisierul este apelat direct din browser (cum e acum, fara ruter complet)
    // inițializăm noi Controller-ul care va apela Modelul și va randa acest fisier din nou, cu datele gata pregatite.
    require_once __DIR__ . '/../../controllers/EventController.php';
    $controller = new EventController();
    $controller->showDetails($_GET['id'] ?? 0, $_GET['type'] ?? '');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii Eveniment - CoA</title>

    <!-- CSS Global și CSS specific detaliilor publice -->
    <link rel="stylesheet" href="public/css/global.css">
    <link rel="stylesheet" href="public/css/details-public.css">

    <!-- Leaflet.js CSS pentru hartă -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body>
    <?php
    $active_page = 'events';
    include __DIR__ . '/../layouts/header.php';
    ?>

    <!-- Container principal (centrat) -->
    <div style="padding: 2rem; max-width: 1200px; margin: 0 auto; width: 100%;">
        
        <!-- Buton de înapoi -->
        <nav class="inapoi-btn">
            <a href="index.php?route=events-public">← Înapoi la Evenimente</a>
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
    <script src="public/js/main.js"></script>
</body>
</html>