<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Utilizatori - CoA ADMIN</title>

    <link rel="stylesheet" href="../../../public/css/global.css">
    <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
    <link rel="stylesheet" href="../../../public/css/events.css">
</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; ?>

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
                        <input type="text" id="user_name" name="user_name" placeholder="ex: Ion Popescu" required>
                    </div>

                    <div class="form-field">
                        <label for="user_email">Email</label>
                        <input type="email" id="user_email" name="user_email" placeholder="ex: ion@autoritate.ro" required>
                    </div>

                    <div class="form-field" id="password-field">
                        <label for="user_password">Parolă</label>
                        <input type="password" id="user_password" name="user_password" placeholder="••••••••">
                    </div>

        
                    <div class="form-field" >
                        <label for="user_county">Județ</label>
                            <select id="user_county" name="user_county" required>
                                <option value="">Selectează</option>
                                <option value="braila">j1</option>
                                <option value="vrancea">j2</option>
                                <option value="buzau">j3</option>
                                <option value="galati">j4</option>
                                <option value="tulcea">j6</option>
                                <option value="bacau">j5</option>
                            </select>
                        </div>
            

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('modal-user')">Anulează</button>
                        <button type="submit" id="modal-user-btn" class="btn-submit">Salvează</button>
                    </div>

                </form>
            </div>
        </div>

        <main class="events-content">

            <div class="header-events">
                <h1>Gestionare utilizatori</h1>
                <button class="add-event-btn" onclick="openUserModal('add')">
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
                <tbody>
                    <tr>
                        <td>Ion Popescu</td>
                        <td>ion.popescu@gmail.ro</td>
                        <td>judet </td>
                        <td>Acum 5 min</td>
                        <td class="actions">
                            <a href="#" onclick="openUserModal('edit'); return false;">Editează</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Dezactivează</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Maria Ionescu</td>
                        <td>maria.ionescu@gmail.ro</td>
                        <td>Vrancea</td>
                        <td>Acum 12 min</td>
                        <td class="actions">
                            <a href="#" onclick="openUserModal('edit'); return false;">Editează</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Dezactivează</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Andrei Georgescu</td>
                        <td>andrei.g@gmail.ro</td>
                        <td>Buzău</td>
                        <td>Acum 1 oră</td>
                        <td class="actions">
                            <a href="#" onclick="openUserModal('edit'); return false;">Editează</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Dezactivează</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Elena Dumitrescu</td>
                        <td>elena.d@galati.ro</td>
                        <td>Galați</td>
                        <td>Acum 2 ore</td>
                        <td class="actions">
                            <a href="#" onclick="openUserModal('edit'); return false;">Editează</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Dezactivează</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Cristian Popa</td>
                        <td>cristian.popa@gmail.ro</td>
                        <td>Tulcea</td>
                        <td>Acum 3 ore</td>
                        <td class="actions">
                            <a href="#" onclick="openUserModal('edit'); return false;">Editează</a>
                            <a href="#" class="delete" onclick="confirmDelete(this); return false;">Dezactivează</a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>