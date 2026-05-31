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



            <table class="list-events">

                <thead class="header-list-events">
                   <tr>
                    <th scope="col">Status eveniment</th>
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
        
            </table>
        </main>
    </div>


</body>

</html>

