<!DOCTYPE html>
<html lang="ro">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenimente și Alerte - CoA</title>
    
    <!-- css global -->
    <link rel="stylesheet" href="public/css/global.css">
    
    <!-- leaflet pt harta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- css layout harta + lista -->
    <link rel="stylesheet" href="public/css/map-page.css">
</head>
<body>
    <?php
    $active_page = 'events';
    include __DIR__ . '/../layouts/header.php';
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

        // Apelăm endpoint-ul unificat pentru evenimente
        fetch('index.php?route=api/events')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(events => {
                
                if (events.error) {
                    console.error("Eroare DB: ", events.error);
                    listContainer.innerHTML = '<p>Eroare la încărcarea evenimentelor.</p>';
                    return;
                }

                if (events.length === 0) {
                    listContainer.innerHTML = '<p>Nu s-au găsit evenimente.</p>';
                    return;
                }

            // Array pentru a ține evidența markerelor de pe hartă
            var allMarkers = [];

            events.forEach(function(ev) {
                // Determinăm clasele CSS pe frontend (UI logic), nu în PHP
                let filtertype = 'rezolvat', colorclass = 'border-teal', badgeclass = 'bg-teal';
                if (ev.status) {
                    let stat = ev.status.toLowerCase();
                    if (stat.includes('activ')) {
                        filtertype = 'activ'; colorclass = 'border-red'; badgeclass = 'bg-red';
                    } else if (stat.includes('monitorizare')) {
                        filtertype = 'monitorizare'; colorclass = 'border-orange'; badgeclass = 'bg-orange';
                    }
                }

                var marker = L.marker([parseFloat(ev.lat), parseFloat(ev.lng)]).addTo(map);
                marker.bindPopup(`<b>${ev.title}</b><br>${ev.location}`);

                // Salvăm referința markerului pentru a-l filtra mai jos
                allMarkers.push({
                    marker: marker,
                    filterType: filtertype
                });

                var cardHTML = `
                    <div class="card ${colorclass}" data-type="${filtertype}">
                        <div class="card-badges">
                            <span class="badge ${badgeclass}">${ev.status ? ev.status.toUpperCase() : ''}</span>
                        </div>
                        <h3>${ev.title}</h3>
                        <p class="location"> ${ev.location}</p>
                        <p class="time"> ${ev.details}</p>
                        <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                            <a href="index.php?route=details-public&id=${ev.id}&type=${ev.type}" class="btn-link" style="margin-top: 0;">Vezi detalii</a>
                            <a href="#" class="btn-link" style="margin-top: 0;" onclick="map.setView([${ev.lat}, ${ev.lng}], 10); return false;">Vezi pe hartă &rarr;</a>
                        </div>
                    </div>
                `;
                
                listContainer.innerHTML += cardHTML;
            });

            // FILTRARE BUTOANE
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Schimbăm clasa 'active' pe butoane
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');
                    
                    // Filtrăm cardurile
                    const cards = document.querySelectorAll('#events-list .card');
                    cards.forEach(card => {
                        if (filterValue === 'all' || card.getAttribute('data-type') === filterValue) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Filtrăm markerele de pe hartă
                    allMarkers.forEach(item => {
                        if (filterValue === 'all' || item.filterType === filterValue) {
                            if (!map.hasLayer(item.marker)) map.addLayer(item.marker);
                        } else {
                            if (map.hasLayer(item.marker)) map.removeLayer(item.marker);
                        }
                    });
                });
            });
        })
        .catch(error => {
            console.error("Eroare la preluarea datelor:", error);
            listContainer.innerHTML = `<p>Nu s-au putut încărca evenimentele. Verificați conexiunea.</p>`;
        });
    </script>
    
    <script src="public/js/main.js"></script>

  
</body>
</html>