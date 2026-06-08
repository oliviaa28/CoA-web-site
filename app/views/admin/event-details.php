<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalii eveniment - CoA ADMIN</title>

  <link rel="stylesheet" href="public/css/global.css">
  <link rel="stylesheet" href="public/css/forms.css">
  <link rel="stylesheet" href="public/css/admin.css">  
  <link rel="stylesheet" href="public/css/events.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>
    <div class="admin-layout">
          <?php include __DIR__ . '/../layouts/sidebar.php'; 
                 include __DIR__ . '/modal-event.php'; 
                 include __DIR__ . '/modal-alert.php';?>

        <main class="events-content">

        <nav class="inapoi-btn">
            <a href="index.php?route=events"> <- Înapoi la evenimente</a>
        </nav>

            <!-- Header eveniment -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge" id="event-badge">...</span>
                    <h1 id="event-name">...</h1>
                    <p class="current-date" id="event-address-header">...</p>
                </div>
                <div class="event-detail-actions">
                    <button class="btn-cap"  onclick="deschideAlertaDinEveniment()"> Trimite alerta</button>
                    <button class="btn-edit" onclick="editeazaEvenimentDetalii()"> Editeaza</button>
                    <button class="btn-delete" onclick="stergeEvenimentDetalii()" > Sterge</button>
                </div>
            </div>


            <!-- Harta + paneluri -->
            <div class="event-detail-body">

                <!-- Harta -->
                <div class="event-map">
                    <!-- Leaflet.js va fi initializat aici -->
                    <div id="event-map" style="height: 350px; width: 100%; border-radius: 8px; z-index: 1;"></div> 
                    <div class="map-footer">
                        <span> — Raza impact: ~80km</span>
                    </div>
                </div>

                <!-- Paneluri dreapta -->
                <div class="event-detail-panels">

                    <div class="detail-panel">
                        <h3>Descriere</h3>
                        <p>.............. </p>
                    </div>

                </div>
            </div>

            <div class="alerts-section">
                <h2>Alerte trimise pentru acest eveniment</h2>
                <table class="list-events">
                     <thead>
                        <tr>
                         <th>Titlu</th>
                         <th>Severitate</th>
                         <th>Trimis la</th>
                         <th>Status</th>
                         <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>


        </main>
    </div>

    <script src="public/js/main.js"></script>
    <script src="public/js/admin.js"></script>
    <script src="public/js/details.js"></script>
</body>

</html>