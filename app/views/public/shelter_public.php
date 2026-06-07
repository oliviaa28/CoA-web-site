<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăposturi și Puncte de Sprijin - CoA</title>
    
    <link rel="stylesheet" href="../../../public/css/global.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Adaugat pentru Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    
    <link rel="stylesheet" href="../../../public/css/map-page.css">
</head>
<body>
    <?php
    $active_page = 'shelters';
    include '../layouts/header.php';
    ?>

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
    <!-- Adaugat pentru Leaflet Routing Machine -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        // init harta
        var map = L.map('shelters-map').setView([47.165, 27.58], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var listContainer = document.getElementById('shelters-list');

        // Variabila pentru a stoca controlul de rutare, ca sa il putem sterge/inlocui
        let routingControl = null;

        // fetch date db
            fetch('../../../api/shelters.php')
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

                // Afișăm în consolă datele brute primite de la PHP
                console.log("Date primite din DB:", shelters);

                // Array pentru a tine evidenta markerelor de pe harta
                var allMarkers = [];

                //  markerele și cardurile
                shelters.forEach(function(shelter) {
                    // Asigurăm formatul corect pentru coordonate (le transformăm în numere)
                    const lat = parseFloat(shelter.lat);
                    const lng = parseFloat(shelter.lng);


                    // Determinăm culorile din JavaScript
                    let filtertype = 'provizii', colorclass = 'border-teal', badgeclass = 'bg-teal';
                    let tip = shelter.type ? shelter.type.toLowerCase() : '';
                    if (tip.includes('medical') || tip.includes('ajutor')) {
                        filtertype = 'medical'; colorclass = 'border-red'; badgeclass = 'bg-red';
                    } else if (tip.includes('buncar') || tip.includes('buncăr') || tip.includes('subteran')) {
                        filtertype = 'buncar'; colorclass = 'border-orange'; badgeclass = 'bg-orange';
                    }

                    // Marker pe hartă
                    var marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(`<b>${shelter.name}</b><br>${shelter.type}`);

                    // Salvăm referința markerului pentru a-l filtra mai jos
                    allMarkers.push({
                        marker: marker,
                        filterType: filtertype
                    });

                    // Generare Card HTML
                    var cardHTML = `
                        <div class="card ${colorclass}" data-type="${filtertype}">
                            <div class="card-badges">
                                <span class="badge ${badgeclass}">${shelter.type}</span>
                            </div>
                            <h3>${shelter.name}</h3>
                            <p class="location"> ${shelter.address}</p>
                            <p class="time"> ${shelter.details}</p>
                            
                            <div class="card-actions">
                                <a href="#" class="btn-link" onclick="map.setView([${lat}, ${lng}], 16); return false;">Vezi pe hartă &rarr;</a>
                                <a href="#" class="btn-link directions-link" data-lat="${lat}" data-lng="${lng}">Obține direcții &rarr;</a>
                            </div>
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

                // GESTIONARE CLICK PE "OBTINE DIRECTII"
                // Folosim event delegation pe containerul listei
                listContainer.addEventListener('click', function(e) {
                    // Verificam daca elementul pe care s-a dat click este link-ul de directii
                    if (e.target && e.target.classList.contains('directions-link')) {
                        e.preventDefault(); // Prevenim comportamentul default al link-ului

                        const shelterLat = parseFloat(e.target.getAttribute('data-lat'));
                        const shelterLng = parseFloat(e.target.getAttribute('data-lng'));

                        // Funcție helper pentru a desena ruta
                        const drawRoute = (userLat, userLng) => {
                            if (routingControl) {
                                map.removeControl(routingControl);
                            }
                            routingControl = L.Routing.control({
                                waypoints: [
                                    L.latLng(userLat, userLng),      // Punct de start
                                    L.latLng(shelterLat, shelterLng) // Punct de sosire
                                ],
                                routeWhileDragging: true
                            }).addTo(map);
                        };

                        // Funcție fallback pentru locația aproximativă prin IP (folosind ipify și ip-api din routes.php)
                        const fetchIPLocation = () => {
                            fetch('../../../api/routes.php')
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        drawRoute(data.lat, data.lng);
                                    } else {
                                        alert("Eroare API locație: " + data.error);
                                    }
                                })
                                .catch(err => {
                                    console.error("Eroare la preluarea locației:", err);
                                    alert("Eroare de rețea. Nu am putut obține locația exactă sau aproximativă.");
                                });
                        };

                        // 1. Încercăm locația exactă (GPS/Wi-Fi) prin browser
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                function(position) { drawRoute(position.coords.latitude, position.coords.longitude); },
                                function(error) { 
                                    console.warn("Geolocația exactă a eșuat, folosim fallback IP.", error);
                                    fetchIPLocation(); // Fallback dacă utilizatorul refuză accesul sau e eroare
                                },
                                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 } // Forțăm GPS-ul / acuratețe maximă
                            );
                        } else {
                            fetchIPLocation(); // Browserul nu suportă geolocație
                        }
                    }
                });
            })
            .catch(error => {
                console.error("Eroare la preluarea datelor:", error);
                listContainer.innerHTML = `<p>Nu s-au putut încărca adăposturile. Verificați conexiunea.</p>`;
            });
    </script>
    
    <script src="../../../public/js/main.js"></script>
</body>
</html>