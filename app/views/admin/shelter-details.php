<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
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

        <nav class="inapoi-btn">
            <a href="shelters.php"> <- Înapoi la adăposturi</a>
        </nav>

            <!-- Header adapost -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge" id="shelter-badge">...</span>
                    <h1 id="shelter-name">...</h1>
                    <p class="current-date" id="shelter-address-header">...</p>
                </div>
              
                  <div class="event-detail-actions">
                    <button class="btn-edit" onclick="editeazaAdapostDetalii()"> Editeaza</button>
                    <button class="btn-delete" onclick="stergeAdapostDetalii()"> Sterge</button>
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
                    <p> <strong>Tip:</strong>
                         <span id="shelter-type"></span>
                    </p>
                    <p>  <strong> Adresa:  </strong>
                        <span id="shelter-address"></span>
                    </p>
                    <p>  <strong> Capacitate totala:  </strong>
                         <span id="shelter-capacity"></span> 
                      persoane
                    </p>
                    <p>  <strong> Locuri disponibile:  </strong>
                         <span id="shelter-available"></span>
                    </p>
                    <p>  <strong> Descriere:  </strong>
                        <span id="shelter-description"></span>
                    </p>
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
    <script src="../../../public/js/admin.js"></script>
    <script src="../../../public/js/details.js"></script>
</body>

</html>