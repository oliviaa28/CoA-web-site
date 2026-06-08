<?php 
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::requireAuth();
?>
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


</head>

<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../layouts/sidebar.php'; 
              include 'modal-event.php'; ?>
        
        <main class="events-content">
    
            <div class="header-events">
               <h1>Gestionare evenimente</h1>

                <!--in dreapta numelui ->butonul de adaguare eveniment -->
            <button class="add-event-btn" onclick="golesteFormular();  openModal('modal-add', 'add')" >
                + Adauga eveniment
            </button>

            </div>

            <div class="filter-event-banner">
                  <div class="filter-event-field">
                    <label for="filter_type">Tip eveniment</label>
                         <select  id="filter_type" name="filter_type">
                            <option value="">Selecteaza tipul</option> 
                            <option value="cutremur">Cutremur</option>
                            <option value="inundatie">Inundatie</option>
                            <option value="incendiu">Incendiu</option>
                        </select>
                   </div>
                
                   <div class="filter-event-field">
                    <label for="filter_status">Status</label>
                         <select  id="filter_status" name="filter_status" >
                            <option value="">Selecteaza statusul</option>
                            <option value="activ">Activ</option>
                            <option value="monitorizare">Monitorizare</option>
                            <option value="rezolvat">Rezolvat</option>
                        </select>
                    </div>   
                     <div class="filter-event-field">
                       <label for="filter_year">An</label>
                        <input type="number" id="filter_year" min="2012" max="2026" placeholder="An">   
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
                
                <tbody id= "events-tbody">
                  <!--  -->
                </tbody>
        
            </table>
        </main>
    </div>
  <script src="../../../public/js/main.js"></script>
  <script src="../../../public/js/admin.js"></script>
</body>

</html>

