<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Import/Export - CoA ADMIN</title>

    <link rel="stylesheet" href="public/css/global.css">
    <link rel="stylesheet" href="public/css/forms.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="public/css/events.css">
     <link rel="stylesheet" href="public/css/import-export.css">
</head>

<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>

        <main class="events-content">

            <div class="header-events">
                <h1>Import/Export date</h1>
            </div>

            <div class="ie-layout">

                <!-- Coloana stanga: Export -->
                <div class="ie-column">
                    <div class="ie-card-header">
                        <h2>Export date</h2>
                    </div>
                    <p class="ie-subtitle">Descarcă date din sistemul CoA în formate standard</p>

                    <div class="ie-item">
                        <div class="ie-item-info">
                            <span class="ie-item-icon">🗐</span>
                            <div>
                                <strong>Export evenimente</strong>
                                <p>Exportă toate evenimentele din baza de date</p>
                            </div>
                        </div>
                        <div class="ie-btns">
                            <button class="ie-btn" onclick="exportData('events', 'json')">JSON</button>
                            <button class="ie-btn" onclick="exportData('events', 'csv')" >CSV</button>
                        </div>
                    </div>

                    <div class="ie-item">
                        <div class="ie-item-info">
                            <span class="ie-item-icon">🗐</span>
                            <div>
                                <strong>Export adăposturi</strong>
                                <p>Exportă lista completă de adăposturi și capacități</p>
                            </div>
                        </div>
                        <div class="ie-btns">
                            <button class="ie-btn" onclick="exportData('shelters', 'json')" >JSON</button>
                            <button class="ie-btn" onclick="exportData('shelters', 'csv')" >CSV</button>
                        </div>
                    </div>

                    <div class="ie-item">
                        <div class="ie-item-info">
                            <span class="ie-item-icon">🗐</span>
                            <div>
                                <strong>Export alerte</strong>
                                <p>Exportă alertele trimise</p>
                            </div>
                        </div>
                        <div class="ie-btns">
                            <button class="ie-btn"  onclick="exportData('alerts', 'json')">JSON</button>
                             <button class="ie-btn"  onclick="exportData('alerts', 'csv')" >CSV</button>

                        </div>
                    </div>

                </div>

                <!-- Coloana dreapta: Import -->
                <div class="ie-column">
                    <div class="ie-card-header">
                        <span class="ie-icon">🗁</span>
                        <h2>Import date</h2>
                    </div>
                    <p class="ie-subtitle">Importă date din surse externe în sistemul CoA</p>

                    <form action ="index.php?route=api/import-export&action=import" method="POST" enctype="multipart/form-data">
                        <div class="form-field">
                              <label for="import-type">Tip date</label>
                                <select id="import-type" name="type" required>
                                        <option value="">Selectează tipul</option>
                                        <option value="events">Evenimente</option>
                                        <option value="shelters">Adăposturi</option>
                                        <option value="alerts">Alerte</option>
                                </select>
                        </div>

                    <div class="form-field">
                        <label for="file-input">Fișier</label>
                        <input type="file" id="file-input" name="fisier" accept=".json,.csv,.xml" required>
                        
                    </div>

                    <button type="submit" class="btn-submit">Importă</button>
                
                   </form>
                   <small>Formate acceptate: JSON, CSV</small>
                </div>

            </div>

        </main>
    </div>

    <script src="public/js/main.js"></script>
    <script src="public/js/admin.js"></script>
</body>

</html>