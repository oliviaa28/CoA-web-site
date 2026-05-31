<!DOCTYPE html> 
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaposturi - CoA ADMIN</title>
 
    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">
</head>

<body>
    <div class="admin-layout">
         <?php include '../layouts/sidebar.php'; 
               include 'modal-shelter.php'; ?>
        

<main class="events-content">
 
            <div class="header-events">
                <h1>Adaposturi</h1>
                <button class="add-event-btn" onclick="openShelterModal('add')">
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
                <tbody>
                    <tr>
                        <td>Scoala Gimnaziala Ion Creanga</td>
                        <td>Str. Vasile Lupu nr. 78, Iasi</td>
                        <td>Buncar</td>
                        <td>280/350</td>
                        <td><span class="badge bg-teal">Disponibil</span></td>
                        <td class="actions">
                            <a href="shelter-details.php">Detalii</a>
                            <a href="#" onclick="openShelterModal('edit'); return false;">Editeaza</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Sterge</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Spitalul Clinic Sf. Spiridon</td>
                        <td>Bd. Independentei nr. 1, Iasi</td>
                        <td>Punct Medical</td>
                        <td>12/80</td>
                        <td><span class="badge bg-orange">Partial</span></td>
                        <td class="actions">
                            <a href="shelter-details.php">Detalii</a>
                            <a href="#" onclick="openShelterModal('edit'); return false;">Editeaza</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Sterge</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Centrul Comunitar Copou</td>
                        <td>Bd. Carol I nr. 11, Iasi</td>
                        <td>Provizii</td>
                        <td>0/200</td>
                        <td><span class="badge bg-red">Plin</span></td>
                        <td class="actions">
                            <a href="shelter-details.php">Detalii</a>
                            <a href="#" onclick="openShelterModal('edit'); return false;">Editeaza</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Sterge</a>
                        </td>
                    </tr>
                </tbody>
            </table>
 
        </main>
    </div>
 
    <script src="../../../public/js/main.js"></script>
</body>
</html>
 