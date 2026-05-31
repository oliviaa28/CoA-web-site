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
        <?php include '../layouts/sidebar.php'; ?>

        <!-- Modal trimitere alerta CAP -->
        <div class="modal-overlay" id="modal-cap" style="display:none;">
            <div class="modal-card">

                <div class="modal-header">
                    <h2>Trimite alertă CAP nouă</h2>
                    <button class="modal-close" onclick="closeModal('modal-cap')"> ✕ </button>
                </div>

                <form class="modal-form" action="/admin/alerts/store" method="POST">

                    <div class="coords-row">
                        <div class="form-field" style="flex:1">
                            <label for="cap_status">Status</label>
                            <select id="cap_status" name="cap_status" required>
                                <option value="">Selectează</option>
                                <option value="Real">Real</option>
                                <option value="Exercitiu">Exercitiu</option>
                                <option value="Test">Test</option>
                            </select>
                        </div>
                        <div class="form-field" style="flex:1">
                            <label for="cap_msgtype">Tip mesaj</label>
                            <select id="cap_msgtype" name="cap_msgtype" required>
                                <option value="">Selectează</option>
                                <option value="Alert">Alert</option>
                                <option value="Update">Update</option>
                                <option value="Cancel">Cancel</option>
                            </select>
                        </div>
                    </div>

                    <div class="coords-row">
                        <div class="form-field" style="flex:1">
                            <label for="cap_urgency">Urgență</label>
                            <select id="cap_urgency" name="cap_urgency" required>
                                <option value="">Selectează</option>
                                <option value="Immediate">Imediagt</option>
                                <option value="Expected">Asteptat</option>
                                <option value="Future">In viitor</option>
                            </select>
                        </div>
                        <div class="form-field" style="flex:1">
                            <label for="cap_severity">Severitate</label>
                            <select id="cap_severity" name="cap_severity" required>
                                <option value="">Selectează</option>
                                <option value="Extreme">Extrema</option>
                                <option value="Severe">Severa</option>
                                <option value="Moderate">Moderata</option>
                                <option value="Minor">Minora</option>
                            </select>
                        </div>
                        <div class="form-field" style="flex:1">
                            <label for="cap_certainty">Certitudine</label>
                            <select id="cap_certainty" name="cap_certainty" required>
                                <option value="">Selectează</option>
                                <option value="Observed">Observat</option>
                                <option value="Likely">Probabil</option>
                                <option value="Possible">Posibil</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="cap_headline">Titlu alertă</label>
                        <input type="text" id="cap_headline" name="cap_headline"
                            placeholder="ex: Cutremur puternic  " required>
                    </div>

                    <div class="form-field">
                        <label for="cap_description">Descriere</label>
                        <textarea id="cap_description" name="cap_description" rows="3"
                            placeholder="Ce s-a întâmplat..."></textarea>
                    </div>

                    <div class="form-field">
                        <label for="cap_instruction">Instrucțiuni pentru populație</label>
                        <textarea id="cap_instruction" name="cap_instruction" rows="3" placeholder="ex: ....... "></textarea>
                    </div>

                    <div class="form-field">
                        <label for="cap_area">Zonă afectată</label>
                        <input type="text" id="cap_area" name="cap_area" placeholder="ex:......">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('modal-cap')">Anulează</button>
                        <button type="submit" class="btn-submit">Trimite alerta</button>
                    </div>

                </form>
            </div>
        </div>

        <main class="events-content">

            <div class="header-events">
                <h1>Alerte CAP</h1>
                <button class="add-event-btn" onclick="openModal('modal-cap')">
                    + Trimite alertă nouă
                </button>
            </div>

            <div class="alert-banner">
                ! 2 alerte active în acest moment
            </div>


            <table class="list-events">
                <thead>
                    <tr>
                        <th scope="col">ID CAP</th>
                        <th scope="col">Tip</th>
                        <th scope="col">Severitate</th>
                        <th scope="col">Trimis la</th>
                        <th scope="col">Destinatari</th>
                        <th scope="col">Status</th>
                        <th scope="col">Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CAP-2026-04-09-001</td>
                        <td>Cutremur</td>
                        <td>Extrem</td>
                        <td>9 Apr 2026, 14:25</td>
                        <td>2.4M</td>
                        <td><span class="badge bg-red">ACTIV</span></td>
                        <td class="actions">
                             <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                    <tr>
                        <td>CAP-2026-04-08-012</td>
                        <td>Inundație</td>
                        <td>Sever</td>
                        <td>8 Apr 2026, 09:20</td>
                        <td>850K</td>
                        <td><span class="badge bg-orange">MONITORIZARE</span></td>
                        <td class="actions">
                            <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                    <tr>
                        <td>CAP-2026-04-07-009</td>
                        <td>Incendiu</td>
                        <td>Moderat</td>
                        <td>7 Apr 2026, 18:50</td>
                        <td>320K</td>
                        <td><span class="badge bg-teal">REZOLVAT</span></td>
                        <td class="actions">
                            <a href="cap-details.php">Vezi detalii</a>
                            <a href="#" class="export">Export XML</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="pagination">
                                <a href="#" class="pagination-btn">← Previous</a>
                                <div class="pagination-numbers">
                                    <a href="#" class="pagination-num active">1</a>
                                    <a href="#" class="pagination-num">2</a>
                                </div>
                                <a href="#" class="pagination-btn">Next →</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>

            </table>

        </main>
    </div>

    <script src="../../../public/js/main.js"></script>
</body>

</html>