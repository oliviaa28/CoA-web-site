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
    <!-- meniu navigare -->
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

        var events = [
            { 
                id: 1, title: "Cutremur M4.2", filterType: "activ", status: "ACTIV",
                location: "Vrancea, România", details: "14:23, Azi • Adâncime 127km", 
                lat: 45.75, lng: 26.65, colorClass: "border-red", badgeClass: "bg-red"
            },
            { 
                id: 2, title: "Inundație Severă", filterType: "monitorizare", status: "MONITORIZARE",
                location: "Galați, România", details: "09:20, Ieri • Cote de atenție depășite pe râul Siret", 
                lat: 45.43, lng: 28.05, colorClass: "border-orange", badgeClass: "bg-orange"
            },
            { 
                id: 3, title: "Incendiu de Vegetație", filterType: "rezolvat", status: "REZOLVAT",
                location: "Brașov, România", details: "18:50, 7 Apr • Focar stins, echipe în retragere", 
                lat: 45.65, lng: 25.60, colorClass: "border-teal", badgeClass: "bg-teal"
            }
        ];

        var listContainer = document.getElementById('events-list');

        events.forEach(function(ev) {
            var marker = L.marker([ev.lat, ev.lng]).addTo(map);
            marker.bindPopup(`<b>${ev.title}</b><br>${ev.location}`);

            var cardHTML = `
                <div class="card ${ev.colorClass}" data-type="${ev.filterType}">
                    <div class="card-badges">
                        <span class="badge ${ev.badgeClass}">${ev.status}</span>
                    </div>
                    <h3>${ev.title}</h3>
                    <p class="location"> ${ev.location}</p>
                    <p class="time"> ${ev.details}</p>
                    <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                        <a href="details_public.php?id=${ev.id}" class="btn-link" style="margin-top: 0;">Vezi detalii</a>
                        <a href="#" class="btn-link" style="margin-top: 0;" onclick="map.setView([${ev.lat}, ${ev.lng}], 10); return false;">Vezi pe hartă &rarr;</a>
                    </div>
                </div>
            `;
            
            listContainer.innerHTML += cardHTML;
        });
    </script>
    
    <script src="/CoA-project/public/js/main.js"></script>

  
</body>
</html>