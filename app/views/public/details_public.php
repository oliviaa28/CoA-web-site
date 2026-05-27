<?php
// Preluăm ID-ul din URL (ex: details_public.php?id=2). Dacă nu există, folosim 1.
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Bază de date simulată (array PHP) pentru evenimente
$eventsData = [
    1 => [
        'title' => 'Cutremur M4.2 Vrancea', 'status' => 'ACTIV', 'badge' => 'bg-red', 'color' => 'var(--color-activ)',
        'date' => '14:23, Azi', 'lat' => 45.75, 'lng' => 26.65, 'epicenter' => 'Zona Vrancea',
        'stat1_label' => 'Magnitudine', 'stat1_val' => '4.2 Mw',
        'stat2_label' => 'Adâncime', 'stat2_val' => '127 km',
        'stat3_label' => 'Arie resimțită', 'stat3_val' => '~80 km',
        'instruction' => 'Păstrați-vă calmul. Adăpostiți-vă sub un birou sau o masă solidă. Stați departe de ferestre, oglinzi și obiecte care pot cădea. Nu folosiți liftul sub nicio formă.',
        'description' => 'Seism înregistrat în zona seismică Vrancea, resimțit ușor în județele adiacente. Până în acest moment nu au fost raportate pagube materiale sau victime.'
    ],
    2 => [
        'title' => 'Inundație Severă Galați', 'status' => 'MONITORIZARE', 'badge' => 'bg-orange', 'color' => 'var(--color-monotorizare)',
        'date' => '09:20, Ieri', 'lat' => 45.43, 'lng' => 28.05, 'epicenter' => 'Județul Galați',
        'stat1_label' => 'Nivel Apă', 'stat1_val' => '+1.5 m',
        'stat2_label' => 'Debit Siret', 'stat2_val' => 'Crescut',
        'stat3_label' => 'Gospodării', 'stat3_val' => '~150 afectate',
        'instruction' => 'Evitați zonele joase și malurile râurilor. Pregătiți un rucsac de urgență. Urmați instrucțiunile autorităților locale pentru evacuare în caz de necesitate.',
        'description' => 'Cote de atenție depășite pe râul Siret, cu risc ridicat de inundații pentru gospodăriile din lunca râului. Echipele de intervenție ISU sunt pe teren pentru monitorizare și asistență.'
    ],
    3 => [
        'title' => 'Incendiu de Vegetație Brașov', 'status' => 'REZOLVAT', 'badge' => 'bg-teal', 'color' => 'var(--color-rezolvat)',
        'date' => '18:50, 7 Apr', 'lat' => 45.65, 'lng' => 25.60, 'epicenter' => 'Zona Brașov',
        'stat1_label' => 'Suprafață', 'stat1_val' => '10 ha',
        'stat2_label' => 'Focare', 'stat2_val' => '0',
        'stat3_label' => 'Echipe', 'stat3_val' => 'Retrase',
        'instruction' => 'Nu mai există niciun pericol imediat. Vă rugăm să evitați deplasările off-road în zona afectată pentru a permite regenerarea solului și a evita inhalarea de cenușă rămasă.',
        'description' => 'Incendiul a fost lichidat cu succes după intervenția a 3 echipaje de pompieri pe parcursul a 6 ore. Nu au fost afectate zone rezidențiale sau cabane.'
    ]
];

// Dacă cineva pune un ID inexistent, îi dăm primul eveniment
if (!isset($eventsData[$eventId])) {
    $eventId = 1;
}
$event = $eventsData[$eventId];
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
    <!-- Navbar (Același ca pe restul paginilor publice) -->
    <nav class="navbar">
        <div class="logo">
            <div class="dot"></div>
            <strong>CoA</strong>
        </div>
        <button class="menu-toggle" id="mobile-menu-btn">☰</button>
        <ul class="nav-links" id="nav-links">
            <li><a href="/CoA-project/public/index.html">Acasă</a></li>
            <li><a href="/CoA-project/app/views/public/events_public.php" class="active">Evenimente</a></li>
            <li><a href="/CoA-project/app/views/public/shelter_public.php">Adăposturi</a></li>
            <li class="mobile-login"><a href="/CoA-project/app/views/public/login.html" class="btn-login">Login </a></li>
        </ul>
        <a href="/CoA-project/app/views/public/login.html" class="btn-login desktop-login">Login </a>
    </nav>

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