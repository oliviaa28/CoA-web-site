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

            <!-- Breadcrumb -->
            <nav class="inapoi-btn">
                <a href="alerts.php">Alerte CAP</a>
                <span> > </span>
                <span>CAP-2026-04-09-001</span>
            </nav>

            <!-- Header -->
            <div class="event-detail-header">
                <div class="event-detail-left">
                    <span class="badge bg-red">ACTIV</span>
                    <h1>Cutremur puternic în zona Vrancea</h1>
                    <p class="current-date">Trimis: 9 Aprilie 2026, 14:25</p>
                </div>
                <div class="event-detail-actions">
                    <button class="btn-edit">Export XML</button>
                    <button class="btn-delete" onclick="confirmDelete(this); return false;">Anulează alerta</button>
                </div>
            </div>

            <!-- Stat cards -->
            <div class="status-cards">
                <div class="status-card dark">
                    <span class="status-label">Severitate</span>
                    <span class="status-number">Extreme</span>
                </div>
                <div class="status-card dark">
                    <span class="status-label">Urgență</span>
                    <span class="status-number">Immediate</span>
                </div>
                <div class="status-card dark">
                    <span class="status-label">Certitudine</span>
                    <span class="status-number">Observed</span>
                </div>
                <div class="status-card dark">
                    <span class="status-label">Destinatari</span>
                    <span class="status-number">2.4M</span>
                </div>
            </div>

            <!-- Corp pagina -->
            <div class="event-detail-body">

                <!-- Stanga: Descriere + Instructiuni -->
                <div class="event-detail-panels" style="flex:2">
                    <div class="detail-panel">
                        <h3>Descriere</h3>
                        <p>muncitori la ap de sus</p>
                    </div>
                    <div class="detail-panel">
                        <h3>Instrucțiuni pentru populație</h3>
                        <p>puteti dormi linistiti.....</p>
                    </div>
                </div>

                <!-- Dreapta: Metadate -->
                <div class="event-detail-panels" style="flex:1">
                    <div class="detail-panel cap-panel">
                        <h3>Detalii CAP</h3>
                        <p><strong>ID:</strong> CAP-2026-04-09-001</p>
                        <p><strong>Tip mesaj:</strong> Alert</p>
                        <p><strong>Status:</strong> Actual</p>
                        <p><strong>Categorie:</strong> Geo </p>
                        <p><strong>Zonă afectată:</strong> .... localitati </p>
                        <p><strong>Trimis la:</strong> 89 Apr 2026, 00:25</p>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>