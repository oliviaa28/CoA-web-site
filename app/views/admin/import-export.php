<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Import/Export - CoA ADMIN</title>

    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">
     <link rel="stylesheet" href="../../../public/css/import-export.css">
</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; ?>

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
                            <button class="ie-btn">JSON</button>
                            <button class="ie-btn">CSV</button>
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
                            <button class="ie-btn">JSON</button>
                            <button class="ie-btn">CSV</button>
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
                            <button class="ie-btn">XML</button>
                            <button class="ie-btn">JSON</button>
                             <button class="ie-btn">CSV</button>

                        </div>
                    </div>

                    <div class="ie-item">
                        <div class="ie-item-info">
                            <span class="ie-item-icon">🗐</span>
                            <div>
                                <strong>Export utilizatori</strong>
                                <p>Exportă lista de utilizatori și roluri</p>
                            </div>
                        </div>
                        <div class="ie-btns">
                            <button class="ie-btn">CSV</button>
                            <button class="ie-btn">JSON</button>
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

                    <!-- Zona upload -->
                    <div class="ie-upload-zone" onclick="document.getElementById('file-input').click()">
                        <span class="ie-upload-icon">⬇</span>
                        <p>Trage fișiere aici sau click pentru a încărca</p>
                        <small>Formate acceptate: JSON, CSV, XML</small>
                        <input type="file" id="file-input" accept=".json,.csv,.xml" style="display:none">
                    </div>
                    <button class="btn-submit" onclick="document.getElementById('file-input').click()" >
                        Selectează fișier
                    </button>

                </div>

            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>