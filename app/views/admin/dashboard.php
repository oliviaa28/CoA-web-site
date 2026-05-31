
<!DOCTYPE html>
<html lang="ro">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina Autoritati - CoA</title>
  <link rel="stylesheet" href="../../../public/css/global.css">
  <link rel="stylesheet" href="../../../public/css/forms.css">
    <link rel="stylesheet" href="../../../public/css/admin.css">
</head>

<body>
    <div class="admin-layout">
        <?php include '../layouts/sidebar.php'; ?> <!-- includem side bar ul -->
        
        <main class="admin-content">

            <!-- mesaj personalizat cu numele userului + data din ziua curent 
             nu am adaugat stilizare additionala inca pentru ele, dar le-am dat clase-->
            <div class="greet-user">
                 <h1 class="hello-user">Buna ziua, Administrator!</h1>
                 <p class="current-date">Marti, 28 Mai 2045</p>
            </div>

            <div class="alert-banner">
                 1 eveniment activ necesita atentie ->
            </div>

            <div class="status-cards">
                
                <!--Evenimente active -->
                <div class="status-card" > 
                    <span class="status-number">3</span>
                    <span class="status-label">Evenimente active</span>
                </div>

                <!--Alerte trimise azi -->
                <div class="status-card">
                    <span class="status-number">12</span>
                    <span class="status-label">Alerte trimise azi</span>
                </div>

                <!--Adaposturi disponibile-->
                <div class="status-card">
                    <span class="status-number">847</span>
                    <span class="status-label">Adaposturi disponibile</span>
                </div>

                <!--Utilizatori activi-->
                <div class="status-card">
                    <span class="status-number">1542</span>
                    <span class="status-label">Utilizatori activi</span>
                </div>
            </div>
            
           <form class="add-event-fast" action="/admin/events/store" method="POST">
            <p class="form-title">Adaugati un eveniment rapid</p>
             <div class="form-field">
                    <label for="event_type">Tip eveniment</label>
                         <select id="event_type" name="event_type" required>
                            <option value="">Selecteaza tipul</option>
                            <option value="cutremur">Cutremur</option>
                            <option value="inundatie">Inundatie</option>
                            <option value="incendiu">Incendiu</option>
                            <option value="altele">Altele</option>
                        </select>
             </div>

             <div class="form-field">
                <label for="event_title"> Titlu </label>
                    <input type="text" id="event_title" name="event_title" placeholder="ex: Cutremur  Vrancea" required>
             </div>
                
             <div class="form-field">
                <label for="event_severity">Severitate</label>
                    <select id="event_severity" name="event_severity" required>
                            <option value="">Selecteaza severitatea</option>
                            <option value="scazut">Scazut</option>
                            <option value="mediu">Mediu</option>
                            <option value="ridicat">Ridicat</option>
                            <option value="critic">Critic</option>
                    </select>
            </div>

            <div class="form-field">
               <label for="event_description">Descriere</label>
                    <textarea id="event_description" name="event_description" rows="4" placeholder="Detalii eveniment..."> </textarea>
            </div>

            <button type="submit" class="btn-submit">Adauga eveniment</button>
   
          </form>
           
        </main>
    </div>
</body>

</html>

