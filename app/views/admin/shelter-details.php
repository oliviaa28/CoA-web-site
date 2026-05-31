<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii adapost - CoA ADMIN</title>

    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">

    <!-- Leaflet  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; ?>

        <!-- Modal editare adapost -->
        <?php include 'modal-shelter.php'; ?>

        <main class="events-content">

            <!-- Breadcrumb -->
            <nav class="inapoi-btn">
                <a href="shelters.php">Adaposturi</a>
                <span> > </span>
                <span>NUMEW</span>
            </nav>

            <!-- Header adapost -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge bg-teal">DISPONIBIL</span>
                    <h1>Scoala Gimnaziala Ion Creanga</h1>
                    <p class="current-date">Str. Vasile Lupu nr. 78, Iasi</p>
                </div>
              
                  <div class="event-detail-actions">
                    <button class="btn-edit" onclick="openShelterModal( 'edit')"> Editeaza</button>
                    <button class="btn-delete" onclick="confirmDelete(this); return false;"> Sterge</button>
                </div>
            </div>

            <!-- Harta + detalii -->
            <div class="event-detail-body">

                <!-- Harta cu pinul adapostului -->
                <div class="event-map">
                    <div id="shelter-map" ></div>
                    <div class="map-footer">
                        <span>Iasi, Romania</span>
                    </div>
                </div>

                <!-- Detalii dreapta -->
                <div class="event-detail-panels">

                    <div class="detail-panel">
                        <h3>Detalii adapost</h3>
                        <p>Tip: Buncar</p>
                        <p>Adresa:  Str. Vasile Lupu nr. 78, Iasi</p>
                        <p>Capacitate totala: 350 persoane</p>
                        <p>Locuri disponibile: 280</p>
                        <p>Descriere:  Sala de sport reamenajata. Apa potabila, electricitate de rezerva, grupuri sanitare.</p>
                    </div>

                    <div class="detail-panel">
                        <h3>Ruta de evacuare</h3>
                        <p>Punct de plecare: Piata Unirii, Iasi</p>
                        <p>Ruta: Bd. Stefan cel Mare, evitand zonele cu cladiri inalte</p>
                        <a href="#" class="btn-link"> Vezi ruta pe harta </a>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>