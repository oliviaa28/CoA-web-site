<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Alerte CAP - CoA ADMIN</title>

    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">
</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; 
              include 'modal-alert.php'; ?>
    

        <main class="events-content">

            <div class="header-events">
                <h1>Alerte </h1>
                <button class="add-event-btn" onclick="openModal('modal-cap')">
                    + Trimite alertă nouă
                </button>
            </div>

            <table class="list-events">
                <thead>
                    <tr>
                        <th scope="col">Tip</th>
                        <th scope="col">Severitate</th>
                        <th scope="col">Trimis la</th>
                        <th scope="col">Status eveniment</th>
                        <th scope="col">Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Cutremur</td>
                        <td>Extrem</td>
                        <td>9 Apr 2026, 14:25</td>
                        <td><span class="badge bg-red">ACTIV</span></td>
                        <td class="actions">
                             <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Inundație</td>
                        <td>Sever</td>
                        <td>8 Apr 2026, 09:20</td>
                        <td><span class="badge bg-orange">MONITORIZARE</span></td>
                        <td class="actions">
                            <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                    <tr>

                        <td>Incendiu</td>
                        <td>Moderat</td>
                        <td>7 Apr 2026, 18:50</td>
                        <td><span class="badge bg-teal">REZOLVAT</span></td>
                        <td class="actions">
                            <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                </tbody>

            </table>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>