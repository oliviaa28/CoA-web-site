<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerte - CoA</title>
    <link rel="stylesheet" href="public/css/global.css">
    <link rel="stylesheet" href="public/css/map-page.css">
</head>
<body>
    <?php
    $active_page = 'alerts';
    include __DIR__ . '/../layouts/header.php';
    ?>

    <main style="padding: 2rem; max-width: 800px; margin: 0 auto; width: 100%;">
        <div style="margin-bottom: 2rem; text-align: center;">
            <h1 style="color: var(--text-main); margin-bottom: 0.5rem;">Alerte Publice</h1>
            <p style="color: var(--text-muted);">Situații de urgență și avertizări active emise pentru populație.</p>
        </div>

        <!-- Containerul curățat de marginile stângi implicite -->
        <div class="list-container" id="alerts-list" style="border-left: none; padding: 0; background: transparent;"></div>
    </main>

    <script src="public/js/alerts_public.js"></script>
    <script src="public/js/main.js"></script>
</body>
</html>
