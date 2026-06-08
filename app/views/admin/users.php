<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Utilizatori - CoA ADMIN</title>

    <link rel="stylesheet" href="public/css/global.css">
    <link rel="stylesheet" href="public/css/forms.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="public/css/events.css">
</head>

<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../layouts/sidebar.php'; ?>
        <?php include __DIR__ . '/judete.php'; ?>

        <!-- Modal adauga/editeaza utilizator -->
        <div class="modal-overlay" id="modal-user" style="display:none;">
            <div class="modal-card">

                <div class="modal-header">
                    <h2 id="modal-user-title">Adaugă utilizator</h2>
                    <button class="modal-close" onclick="closeModal('modal-user')">✕</button>
                </div>

                <form class="modal-form" action="/admin/users/store" method="POST">

                    <div class="form-field">
                        <label for="user_name">Nume</label>
                        <input type="text" id="user_name" name="user_name" placeholder="ex: Coca Aleaxndru" required>
                    </div>

                    <div class="form-field">
                        <label for="user_email">Email</label>
                        <input type="email" id="user_email" name="user_email" placeholder="ex: alex@politist.ro" required>
                    </div>

                    <div class="form-field" id="password-field">
                        <label for="user_password">Parolă</label>
                        <input type="password" id="user_password" name="user_password" placeholder="••••••••">
                    </div>

        
                    <div class="form-field" >
                        <label for="user_county">Judet</label>
                             <select id="user_county" name="user_county" required>
                                    <option value="">Selecteaza judetul</option>
                                        <?php foreach ($judete as $judet): ?>
                                                <option value="<?php echo $judet; ?>">
                                                        <?php echo $judet; ?>
                                                </option>
                                        <?php endforeach; ?>
                             </select>
                    </div>
            

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('modal-user')">Anulează</button>
                        <button type="button" id="modal-user-btn" class="btn-submit" onclick="salveazaUser()"  >Salvează</button>
                    </div>

                </form>
            </div>
        </div>

        <main class="events-content">

            <div class="header-events">
                <h1>Gestionare utilizatori</h1>
                <button class="add-event-btn" onclick="golesteFormularUseri(); openUserModal('add')">
                    + Adaugă utilizator
                </button>
            </div>

            <table class="list-events">
                <thead>
                    <tr>
                        <th scope="col">Nume</th>
                        <th scope="col">Email</th>
                        <th scope="col">Județ</th>
                        <th scope="col">Ultima activitate</th>
                        <th scope="col">Acțiuni</th>
                    </tr>
                </thead>
                 <tbody id='users-tbody'>
                        <!-- completet in JS-->
                </tbody>
            </table>

        </main>
    </div>

    <script src="public/js/main.js"></script>
    <script src="public/js/admin.js"></script>
</body>

</html>