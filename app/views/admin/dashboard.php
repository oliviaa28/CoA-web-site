<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();

$numeAdmin =$_SESSION['nume'] ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina Autoritati - CoA</title>
  <link rel="stylesheet" href="../../../public/css/global.css">
  <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
</head>

<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?> <!-- includem side bar ul -->
        
        <main class="admin-content">

            <!-- mesaj personalizat cu numele userului, luat din sesiune-->
            <div class="greet-user">
                 <h1 class="hello-user">Bine ai venit,
                                     <?php echo htmlspecialchars($numeAdmin); ?> ! 
                 </h1>
            </div>


            <div class="status-cards">
                
                <!--Evenimente active -->
                <div class="status-card" > 
                    <span class="status-number"  id="stat-evenimente">-</span>
                    <span class="status-label">Evenimente active</span>
                </div>

                <!--Alerte trimise azi -->
                <div class="status-card">
                    <span class="status-number" id="stat-alerte">-</span>
                    <span class="status-label">Alerte trimise azi</span>
                </div>

                <!--Adaposturi disponibile-->
                <div class="status-card" >
                    <span class="status-number" id="stat-adaposturi" >-</span>
                    <span class="status-label">Adaposturi disponibile</span>
                </div>

                <!--Utilizatori activi-->
                <div class="status-card">
                    <span class="status-number"  id="stat-utilizatori" > - </span>
                    <span class="status-label">Utilizatori activi</span>
                </div>
            </div>
            
           <!-- scurtaturi spre pagini (refolosesc status-card) -->
            <h2 class="greet-user">Acces rapid</h2>
            <div class="status-cards">
                <a href="events.php" class="status-card btn-link">
                    <span class="status-number">🗐</span>
                    <span class="status-label">Gestionare evenimente</span>
                </a>
                <a href="alerts.php" class="status-card btn-link">
                    <span class="status-number">🕭</span>
                    <span class="status-label">Alerte</span>
                </a>
                <a href="shelters.php" class="status-card btn-link">
                    <span class="status-number">🏠︎</span>
                    <span class="status-label">Adaposturi</span>
                </a>
                <a href="import-export.php" class="status-card btn-link">
                    <span class="status-number">🗁</span>
                    <span class="status-label">Import / Export</span>
                </a>
            </div>

            <!-- info despre platforma   -->
            <div class="info">
                <p class="form-title">Despre platforma CoA </p>
                <p>Acesta este panoul de administrare CoA. De aici poti gestiona evenimentele de urgenta 
                    (cutremure, inundatii, incendii), trimite alerte CAP catre populatia afectata si coordona 
                    adaposturile disponibile. </p>
                <p>Verifica periodic evenimentele active si starea adaposturilor. </p>
            </div>
        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
    <script src="../../../public/js/admin.js"></script>
</body>

</html>