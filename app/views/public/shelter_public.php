<?php
// TEST: Conectare și preluare date dintr-o bază de date Oracle (folosind PL/SQL)
$sheltersData = [];
$username = 'CoA'; 
$password = 'CoA_admin'; 
$connection_string = 'localhost:1521/XE';

$db_error = '';
if (!function_exists('oci_connect')) {
    $db_error = "Extensia OCI8 nu este activată în PHP. Trebuie activată în php.ini.";
    $conn = false;
} else {
    $conn = @oci_connect($username, $password, $connection_string);
    if (!$conn) {
        $e = oci_error();
        $db_error = "Eroare Oracle: " . htmlentities($e['message'], ENT_QUOTES);
    }
}

if ($conn) {
    // Procedură PL/SQL care returnează adăposturile publice printr-un Ref Cursor
    $sql = "BEGIN get_public_shelters(:shelters_cursor); END;";
    $stid = oci_parse($conn, $sql);
    
    $p_cursor = oci_new_cursor($conn);
    oci_bind_by_name($stid, ':shelters_cursor', $p_cursor, -1, OCI_B_CURSOR);
    
    oci_execute($stid);
    oci_execute($p_cursor);
    
    while (($row = oci_fetch_array($p_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        $sheltersData[] = [
            'type' => $row['TIP'], 
            'name' => $row['NUME'], 
            'filterType' => $row['FILTER_TYPE'], 
            'address' => $row['ADRESA'],
            'details' => $row['DETALII'],
            'lat' => (float)$row['LAT'],
            'lng' => (float)$row['LNG'],
            'colorClass' => $row['COLOR_CLASS'], 
            'badgeClass' => $row['BADGE_CLASS']
        ];
    }
    oci_free_statement($stid);
    oci_free_statement($p_cursor);
    oci_close($conn);
} 

// FALLBACK DE TEST: Folosim datele statice (mock data) dacă nu s-a obținut nimic din baza de date
$dbStatusMessage = '';
if (empty($sheltersData)) {
    $dbStatusMessage = '<div style="background-color: var(--color-monotorizare); color: white; padding: 10px; border-radius: 8px; margin-top: 1.5rem; text-align: center;">⚠️ <b>Mod Test:</b> Datele afișate sunt de rezervă. <br><small><b>Motiv:</b> ' . $db_error . '</small></div>';
    $sheltersData = [
        [ 'type' => "Buncăr", 'name' => "Școala Gimnazială (Centru)", 'filterType' => "buncar", 'address' => "Str. Palat, nr. 1", 'details' => "Capacitate 200 persoane • Acces Deschis", 'lat' => 47.1573, 'lng' => 27.5869, 'colorClass' => "border-teal", 'badgeClass' => "bg-teal" ],
        [ 'type' => "Punct Medical", 'name' => "Spitalul Sf. Spiridon - Cort Triage", 'filterType' => "medical", 'address' => "Bd. Independenței, nr. 1", 'details' => "Capacitate 50 paturi • Triage rapid", 'lat' => 47.1670, 'lng' => 27.5815, 'colorClass' => "border-orange", 'badgeClass' => "bg-orange" ],
        [ 'type' => "Provizii", 'name' => "Centrul Comunitar Copou", 'filterType' => "provizii", 'address' => "Bd. Carol I, nr. 11", 'details' => "Apă potabilă, pături, alimente neperisabile", 'lat' => 47.1745, 'lng' => 27.5722, 'colorClass' => "border-red", 'badgeClass' => "bg-red" ]
    ];
} else {
    $dbStatusMessage = '<div style="background-color: var(--color-rezolvat); color: white; padding: 10px; border-radius: 8px; margin-top: 1.5rem; text-align: center;">✅ <b>Live:</b> Date încărcate cu succes din baza de date Oracle!</div>';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăposturi și Puncte de Sprijin - CoA</title>
    
    <!-- CSS Global -->
    <link rel="stylesheet" href="/CoA-project/public/css/global.css">
    
    <!-- Leaflet.js CSS pentru hartă -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- CSS Layout Hartă + Listă -->
    <link rel="stylesheet" href="/CoA-project/public/css/map-page.css">
</head>
<body>
    <!-- Navbar -->
    <?php include '../layouts/header.php'; ?> 

    <div style="padding: 0 1rem; max-width: 98%; margin: 0 auto; width: 100%;">

        <!-- Status conexiune Bază de Date -->
        <?php echo $dbStatusMessage; ?>

        <!-- Bara de Filtre -->
        <div class="filters-bar" style="margin-top: 1.5rem;">
            <button class="filter-btn active" data-filter="all">Toate</button>
            <button class="filter-btn" data-filter="buncar">Buncăre Subterane</button>
            <button class="filter-btn" data-filter="medical">Puncte de Prim Ajutor</button>
            <button class="filter-btn" data-filter="provizii">Centre Provizii</button>
        </div>

        <!-- Container Hartă și Listă -->
        <div class="page-layout-split">
            
            <!-- Secțiunea Hărții -->
            <div class="map-container">
                <div id="shelters-map" style="height: 100%; width: 100%; border-radius: var(--radius-md); z-index: 1;"></div>
            </div>

            <!-- Secțiunea Listei (Flashcard-uri) -->
            <div class="list-container events-list" id="shelters-list">
                <!-- Cardurile vor fi generate din JavaScript -->
            </div>

        </div>
    </div>

    <!-- Scripturi Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('shelters-map').setView([47.165, 27.58], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Preluăm rezultatele PHP și le trecem direct în JavaScript ca JSON
        var shelters = <?php echo json_encode($sheltersData); ?>;

        var listContainer = document.getElementById('shelters-list');

        shelters.forEach(function(shelter) {
            // Marker pe hartă
            var marker = L.marker([shelter.lat, shelter.lng]).addTo(map);
            marker.bindPopup(`<b>${shelter.name}</b><br>${shelter.type}`);

            var cardHTML = `
                <div class="card ${shelter.colorClass}" data-type="${shelter.filterType}">
                    <div class="card-badges">
                        <span class="badge ${shelter.badgeClass}">${shelter.type}</span>
                    </div>
                    <h3>${shelter.name}</h3>
                    <p class="location"> ⚲  ${shelter.address}</p>
                    <p class="time">🛈 ${shelter.details}</p>
                    <a href="#" class="btn-link" onclick="map.setView([${shelter.lat}, ${shelter.lng}], 16); return false;">Vezi pe hartă &rarr;</a>
                </div>
            `;
            
            listContainer.innerHTML += cardHTML;
        });
    </script>
    
    <script src="/CoA-project/public/js/main.js"></script>
</body>
</html>