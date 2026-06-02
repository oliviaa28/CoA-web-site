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
                <tbody id ='alerts-tbody'>
                </tbody>

            </table>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
    <script src="../../../public/js/admin.js"></script>
</body>

</html>