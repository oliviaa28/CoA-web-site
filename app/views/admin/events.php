<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina Autoritati - Evenimente </title>

  <link rel="stylesheet" href="../../../public/css/global.css">
  <link rel="stylesheet" href="../../../public/css/forms.css">
  <link rel="stylesheet" href="../../../public/css/admin.css">
  <link rel="stylesheet" href="../../../public/css/events.css">
  <script src="../../../public/js/main.js"></script>

</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; 
              include 'modal-event.php'; ?>
        
        <main class="events-content">
    
            <div class="header-events">
               <h1>Gestionare evenimente</h1>

                <!--in dreapta numelui ->butonul de adaguare eveniment -->
            <button class="add-event-btn" onclick= "openModal('modal-add', 'add')" >
                + Adauga eveniment
            </button>

            </div>

            <div class="filter-event-banner">
                  <div class="filter-event-field">
                    <label for="event_type">Tip eveniment</label>
                         <select  id="event_type" name="event_type" required>
                            <option value="">Selecteaza tipul</option>
                            <option value="cutremur">Cutremur</option>
                            <option value="inundatie">Inundatie</option>
                            <option value="incendiu">Incendiu</option>
                        </select>
                   </div>
                
                   <div class="filter-event-field">
                    <label for="event_type">Status</label>
                         <select  id="event_type" name="event_type" required>
                            <option value="">Selecteaza statusul</option>
                            <option value="activ">Activ</option>
                            <option value="monitorizare">Monitorizare</option>
                            <option value="rezolvat">Rezolvat</option>
                        </select>
                    </div>       
            </div>



            <div class="status-cards">
                
                <!--Evenimente active -->
                <div class="status-card" > 
                    <span class="status-label">Evenimente active</span>
                    <span class="status-number">10 </span>
                </div>

                <!--Evenimente monotorizate -->
                <div class="status-card">
                    <span class="status-label">Alerte trimise azi</span>
                    <span class="status-number">7888</span>
                </div>

                <!--Evenimente rezolvate(in ultimele 30 dezile )-->
                <div class="status-card">
                    <span class="status-label">Adaposturi disponibile</span>
                    <span class="status-number">0</span>
                </div>

            </div>


            <table class="list-events">

                <thead class="header-list-events">
                   <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Tip</th>
                    <th scope="col">Titlu</th>
                    <th scope="col">Locație</th>
                    <th scope="col">Data/Ora</th>
                    <th scope="col">Acțiuni</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="card-badges">
                      <span class="badge bg-red">ACTIV </span>
                    </td>
                    <td>CUtremur </td>
                    <td>Cutremur M4.2 Vrancea</td>
                    <td>Vrancea, România</td>
                    <td>14:23, azi </td>
                    <td class="actions">
                        <a href="event-details.php">Detalii</a>
                        <a href="#" onclick="openModal('modal-add', 'edit')">Editeaza</a>
                        <a href="#" class="delete" onclick="confirmDelete(this); return false;">Sterge</a>
                    </td>
                  </tr>
                   <tr>
                    <td class="card-badges">
                      <span class="badge bg-orange">Monotorizare</span>
                    </td>
                    <td>CUtremur </td>
                    <td>Cutremur M4.2 Vrancea</td>
                    <td>Vrancea, România</td>
                    <td>14:23, azi </td>
                    <td class="actions">
                        <a href="#">Detalii</a>
                        <a href="#" onclick="openModal('modal-add', 'edit')">Editeaza</a>
                        <a href="#" class="delete">Sterge</a>
                    </td>
                  </tr>
                  <tr>
                    <td class="card-badges">
                      <span class="badge bg-teal">Rezolvat</span>
                    </td>
                    <td>CUtremur </td>
                    <td>Cutremur Vrancea</td>
                    <td>România</td>
                    <td>14:23, azi </td>
                    <td class="actions">
                        <a href="#">Detalii</a>
                        <a href="#" onclick="openModal('modal-add', 'edit')">Editeaza</a>
                        <a href="#" class="delete">Sterge</a>
                    </td>
                  </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                          <div class="pagination">
                                <a href="#" class="pagination-btn"> <- Previous</a>
                
                            <div class="pagination-numbers">
                                <a href="#" class="pagination-num active">1</a>
                                <a href="#" class="pagination-num">2</a>
                                <a href="#" class="pagination-num">3</a>
                            </div>
                
                            <a href="#" class="pagination-btn">Next → </a>
                        </div>
                      </td>
                    </tr>
                </tfoot>


            </table>
        </main>
    </div>


</body>

</html>

