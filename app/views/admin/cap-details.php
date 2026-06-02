<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalii alertă CAP - CoA ADMIN</title>

    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">
</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; ?>

        <main class="events-content">

        <nav class="inapoi-btn">
            <a href="alerts.php"> <- Înapoi la alerte</a>
        </nav>

            <!-- Header -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge" id="alert-badge"></span>
                    <h1 id="alert-detail-headline">...</h1>
                    <p class="current-date" id="alert-sent"></p>
                </div>
                <div class="event-detail-actions">
                    <button class="btn-edit">Export XML</button>
                    <button class="btn-delete" onclick="anuleazaAlerta()">Anulează alerta</button>
                </div>
            </div>

            <!-- Stat cards -->
            <div class="status-cards">
                <div class="status-card dark">
                    <span class="status-label">Severitate</span>
                    <span class="status-number" id="alert-severity">...</span>
                </div>
                <div class="status-card dark">
                    <span class="status-label">Urgență</span>
                    <span class="status-number" id="alert-urgency">...</span>
                </div>
                <div class="status-card dark">
                    <span class="status-label">Zona</span>
                    <span class="status-number" id="alert-area">...</span>
                </div>
            </div>

            <!-- Corp pagina -->
            <div class="event-detail-body">

                <!-- Stanga: Descriere + Instructiuni -->
                <div class="detail-panel">
                    <h3>Descriere</h3>
                    <p id="alert-description">...</p>
                </div>
                <div class="detail-panel">
                    <h3>Instrucțiuni pentru populație</h3>
                    <p id="alert-instruction">...</p>
                </div>

                <div class="detail-panel">
                    <h3>Eveniment asociat</h3>
                    <p id="alert-event-info">...</p>
                    <a id="alert-event-link" href="#" class="btn-link">Vezi evenimentul -></a>
                </div>
            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
    <script src="../../../public/js/admin.js"></script>
    <script src="../../../public/js/details.js"></script>
</body>

</html>