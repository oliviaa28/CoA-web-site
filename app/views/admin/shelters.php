<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
<!DOCTYPE html> 
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaposturi - CoA ADMIN</title>
 
    <link rel="stylesheet" href="public/css/global.css">
    <link rel="stylesheet" href="public/css/forms.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="public/css/events.css">
</head>

<body>
    <div class="admin-layout">
         <?php include __DIR__ . '/../layouts/sidebar.php'; 
               include __DIR__ . '/modal-shelter.php'; ?>
        

<main class="events-content">
 
            <div class="header-events">
                <h1>Adaposturi</h1>
                <button class="add-event-btn" onclick="golesteFormularAdapost(); openShelterModal('add')">
                    + Adauga adapost
                </button>
            </div>
 
 
            <!-- Tabel adaposturi -->
            <table class="list-events">
                <thead>
                    <tr>
                        <th scope="col">Nume</th>
                        <th scope="col">Adresa</th>
                        <th scope="col">Tip</th>
                        <th scope="col">Capacitate</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actiuni</th>
                    </tr>
                </thead>
                <tbody id="shelters-tbody">
                    <!-- se cxompleteaza automat din js  -->
                </tbody>
            </table>
 
        </main>
    </div>
 
    <script src="public/js/main.js"></script>
    <script src="public/js/admin.js"></script>
</body>
</html>
 