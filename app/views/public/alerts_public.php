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

    <div class="filters-bar">
        <button class="filter-btn active" data-filter="all">Toate</button>
        <button class="filter-btn" data-filter="extrem">Extrem</button>
        <button class="filter-btn" data-filter="sever">Sever</button>
        <button class="filter-btn" data-filter="moderat">Moderat</button>
    </div>

    <div class="list-container" id="alerts-list"></div>

    <script>
        fetch('index.php?route=api/alerts')
            .then(r => r.json())
            .then(alerts => {
                var list = document.getElementById('alerts-list');

                if (alerts.error || alerts.length === 0) {
                    list.innerHTML = '<p>Nu există alerte active momentan.</p>';
                    return;
                }

                alerts.forEach(function(al) {
                    var sev = al.severity ? al.severity.toLowerCase() : '';
                    var badgeClass = 'bg-teal', borderClass = 'border-teal';
                    if (sev === 'extrem') { badgeClass = 'bg-red';    borderClass = 'border-red'; }
                    else if (sev === 'sever') { badgeClass = 'bg-orange'; borderClass = 'border-orange'; }

                    list.innerHTML += `
                        <div class="card ${borderClass}" data-severity="${sev}">
                            <div class="card-badges">
                                <span class="badge ${badgeClass}">${al.severity ? al.severity.toUpperCase() : ''}</span>
                                <span class="badge bg-teal">${al.urgency ? al.urgency.toUpperCase() : ''}</span>
                            </div>
                            <h3>${al.headline}</h3>
                            <p class="location">${al.zone}</p>
                            <p class="time">${al.sentAt}</p>
                            ${eventLinkHTML}
                        </div>
                    `;
                });
            })
            .catch(() => {
                document.getElementById('alerts-list').innerHTML = '<p>Nu s-au putut încărca alertele. Verificați conexiunea.</p>';
            });
    </script>

    <script src="public/js/main.js"></script>
</body>
</html>
