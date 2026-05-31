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
                <a href="alerts.php">Alerte</a>
                <span> > </span>
                <span>Nume</span>
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


            </div>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>