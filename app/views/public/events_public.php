<!DOCTYPE html>
<html lang="ro">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente și Alerte - CoA</title>
    
    <!-- css global -->
    <link rel="stylesheet" href="/CoA-project/public/css/global.css">
    
    <!-- leaflet pt harta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- css layout harta + lista -->
    <link rel="stylesheet" href="/CoA-project/public/css/map-page.css">
</head>
<body>
    <?php
    $active_page = 'events';
    include '../layouts/header.php';
    ?>

    <div style="padding: 0 1rem; max-width: 98%; margin: 0 auto; width: 100%;">
        <!-- butoane filtrare -->
        <div class="filters-bar" style="margin-top: 1.5rem;">
            <button class="filter-btn active" data-filter="all">Toate</button>
            <button class="filter-btn" data-filter="activ">Active</button>
            <button class="filter-btn" data-filter="monitorizare">În Monitorizare</button>
            <button class="filter-btn" data-filter="rezolvat">Rezolvate</button>
        </div>

        <!-- container principal harta + lista -->
        <div class="page-layout-split">
            
            <!-- harta -->
            <div class="map-container">
                <div id="events-map" style="height: 100%; width: 100%; border-radius: var(--radius-md); z-index: 1;"></div>
            </div>

            <!-- lista evenimente -->
            <div class="list-container events-list" id="events-list">
                <!-- gen dinamica js -->
            </div>

        </div>
    </div>

    <!-- script leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // setare view ro
        var map = L.map('events-map').setView([45.9, 25.0], 6);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var listContainer = document.getElementById('events-list');

        // Apelăm simultan toate cele 3 tipuri de incidente
        Promise.all([
            fetch('/CoA-project/database/get_incident_cutremur.php').then(r => r.json()).catch(() => []),
            fetch('/CoA-project/database/get_incident_inundatie.php').then(r => r.json()).catch(() => []),
            fetch('/CoA-project/database/get_incident_foc.php').then(r => r.json()).catch(() => [])
        ]).then(([cutremure, inundatii, incendii]) => {
            
            var events = [];
            // Combinăm rezultatele (dacă vin cu erori, le ignorăm pentru a nu pica pagina)
            if (!cutremure.error) events = events.concat(cutremure);
            if (!inundatii.error) events = events.concat(inundatii);
            if (!incendii.error)  events = events.concat(incendii);

            if (events.length === 0) {
                listContainer.innerHTML = '<p>Nu s-au găsit evenimente.</p>';
                return;
            }

            events.forEach(function(ev) {
                var marker = L.marker([parseFloat(ev.lat), parseFloat(ev.lng)]).addTo(map);
                marker.bindPopup(`<b>${ev.title}</b><br>${ev.location}`);

                var cardHTML = `
                    <div class="card ${ev.colorclass}" data-type="${ev.filtertype}">
                        <div class="card-badges">
                            <span class="badge ${ev.badgeclass}">${ev.status ? ev.status.toUpperCase() : ''}</span>
                        </div>
                        <h3>${ev.title}</h3>
                        <p class="location"> ${ev.location}</p>
                        <p class="time"> ${ev.details}</p>
                        <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                            <a href="details_public.php?id=${ev.id}&type=${ev.type}" class="btn-link" style="margin-top: 0;">Vezi detalii</a>
                            <a href="#" class="btn-link" style="margin-top: 0;" onclick="map.setView([${ev.lat}, ${ev.lng}], 10); return false;">Vezi pe hartă &rarr;</a>
                        </div>
                    </div>
                `;
                
                listContainer.innerHTML += cardHTML;
            });
        });
    </script>
    
    <script src="/CoA-project/public/js/main.js"></script>

  
</body>
</html>