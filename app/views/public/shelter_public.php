<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăposturi și Puncte de Sprijin - CoA</title>
    
    <link rel="stylesheet" href="/CoA-project/public/css/global.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <link rel="stylesheet" href="/CoA-project/public/css/map-page.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <div class="dot"></div>
            <strong>CoA</strong>
        </div>
        <button class="menu-toggle" id="mobile-menu-btn">☰</button>
        <ul class="nav-links" id="nav-links">
            <li><a href="Events.php">Acasă</a></li>
            <li><a href="/CoA-project/app/views/public/events_public.php">Evenimente</a></li>
            <li><a href="/CoA-project/app/views/public/shelter_public.php" class="active">Adăposturi</a></li>
            <li class="mobile-login"><a href="/CoA-project/app/views/public/login.html" class="btn-login">Login </a></li>
        </ul>
        <a href="/CoA-project/app/views/public/login.html" class="btn-login desktop-login">Login </a>
    </nav>

    <div style="padding: 0 1rem; max-width: 98%; margin: 0 auto; width: 100%;">
        <div class="filters-bar" style="margin-top: 1.5rem;">
            <button class="filter-btn active" data-filter="all">Toate</button>
            <button class="filter-btn" data-filter="buncar">Buncăre Subterane</button>
            <button class="filter-btn" data-filter="medical">Puncte de Prim Ajutor</button>
            <button class="filter-btn" data-filter="provizii">Centre Provizii</button>
        </div>

        <div class="page-layout-split">
            <div class="map-container">
                <div id="shelters-map" style="height: 100%; width: 100%; border-radius: var(--radius-md); z-index: 1;"></div>
            </div>

            <div class="list-container events-list" id="shelters-list">
                </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // init harta
        var map = L.map('shelters-map').setView([47.165, 27.58], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var listContainer = document.getElementById('shelters-list');

        // fetch date db
            fetch('/CoA-project/database/get_shelters.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(shelters => {
                
                // Verificam daca am primit eroare de la PHP
                if(shelters.error) {
                    console.error("Eroare DB: ", shelters.error);
                    listContainer.innerHTML = `<p>Eroare la încărcarea datelor.</p>`;
                    return;
                }

                 Afișăm în consolă datele brute primite de la PHP
                console.log("Date primite din DB:", shelters);

                // Array pentru a tine evidenta markerelor de pe harta
                var allMarkers = [];

                //  markerele și cardurile
                shelters.forEach(function(shelter) {
                    // Asigurăm formatul corect pentru coordonate (le transformăm în numere)
                    const lat = parseFloat(shelter.lat);
                    const lng = parseFloat(shelter.lng);

                    // DEBUG: Verificăm dacă locațiile sunt valide
                    // console.log("Locație procesată:", lat, lng);

                    // Marker pe hartă
                    var marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(`<b>${shelter.name}</b><br>${shelter.type}`);

                    // Salvăm referința markerului pentru a-l filtra mai jos
                    allMarkers.push({
                        marker: marker,
                        filterType: shelter.filtertype
                    });

                    // Generare Card HTML
                    var cardHTML = `
                        <div class="card ${shelter.colorclass}" data-type="${shelter.filtertype}">
                            <div class="card-badges">
                                <span class="badge ${shelter.badgeclass}">${shelter.type}</span>
                            </div>
                            <h3>${shelter.name}</h3>
                            <p class="location"> ${shelter.address}</p>
                            <p class="time"> ${shelter.details}</p>
                            <a href="#" class="btn-link" onclick="map.setView([${lat}, ${lng}], 16); return false;">Vezi pe hartă &rarr;</a>
                        </div>
                    `;
                    
                    listContainer.innerHTML += cardHTML;
                });

                // FILTRARE
                const filterBtns = document.querySelectorAll('.filter-btn');
                filterBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Schimbăm clasa 'active' pe butoane
                        filterBtns.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        const filterValue = this.getAttribute('data-filter');
                        
                        // Filtrăm cardurile
                        const cards = document.querySelectorAll('#shelters-list .card');
                        cards.forEach(card => {
                            if (filterValue === 'all' || card.getAttribute('data-type') === filterValue) {
                                card.style.display = '';
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        // 3. Filtrăm markerele de pe hartă
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
                listContainer.innerHTML = `<p>Nu s-au putut încărca adăposturile. Verificați conexiunea.</p>`;
            });
    </script>
    
    <script src="/CoA-project/public/js/main.js"></script>
</body>
</html>