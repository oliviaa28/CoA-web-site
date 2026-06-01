<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalii eveniment - CoA ADMIN</title>

  <link rel="stylesheet" href="../../../public/css/global.css">
  <link rel="stylesheet" href="../../../public/css/forms.css">
  <link rel="stylesheet" href="../../../public/css/admin.css">  
  <link rel="stylesheet" href="../../../public/css/events.css">
</head>

<body>
    <div class="admin-layout">
          <?php include '../layouts/sidebar.php'; 
                 include 'modal-event.php'; 
                 include 'modal-alert.php';?>

        <main class="events-content">

            <!-- buton de mers inapoi la evenimente -->
            <nav class="inapoi-btn">
                <a href="events.php">Evenimente</a>
                <span> > </span>
                <span>Cutremur  .... </span>
            </nav>

            <!-- Header eveniment -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge bg-red"> EVENIMENT ACTIV</span>
                    <h1>Cutremur M4.2 Vrancea</h1>
                    <p class="current-date">9 Aprilie 2089, 14:23 EST</p>
                </div>
                <div class="event-detail-actions">
                    <button class="btn-cap"  onclick="openModal('modal-cap')"> Trimite alerta</button>
                    <button class="btn-edit" onclick="openModal('modal-add', 'edit')"> Editeaza</button>
                    <button class="btn-delete" onclick="confirmDelete(this); return false;" > Sterge</button>
                </div>
            </div>


            <!-- Harta + paneluri -->
            <div class="event-detail-body">

                <!-- Harta -->
                <div class="event-map">
                    <!-- Leaflet.js va fi initializat aici -->
                     
                    <div class="map-footer">
                        <span> — Raza impact: ~80km</span>
                    </div>
                </div>

                <!-- Paneluri dreapta -->
                <div class="event-detail-panels">

                    <div class="detail-panel">
                        <h3>Descriere</h3>
                        <p>Seism .............. </p>
                    </div>

                </div>
            </div>

            <!-- Tabel adaposturi recomandate -->
            <div class="shelters-section">
                <h2>Adaposturi recomandate in zona</h2>
                <table class="list-events">
                    <thead>
                        <tr>
                            <th scope="col">Nume</th>
                            <th scope="col">Localitate</th>
                            <th scope="col">Capacitate</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ruta</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>