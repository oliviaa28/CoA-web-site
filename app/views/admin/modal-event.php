    <!-- Modal adaugare eveniment -->
<?php include __DIR__ . '/judete.php'; ?>
  <div class="modal-overlay" id="modal-add" >
       <div class="modal-card">
        
         <div class="modal-header">
            <h2 id="modal-title">Adauga eveniment nou</h2>
            <button class="modal-close" onclick="closeModal('modal-add')"> X </button>   
         </div>

        <form class="modal-form" action="/admin/events/store" method="POST">
            
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
                <label for="event_title">Titlu</label>
                <input type="text" id="event_title" name="event_title"  placeholder="ex: Cutremur IASI" required>
            </div>

            <div class="form-field">
                <label for="event_description">Descriere</label>
                <textarea id="event_description" name="event_description" rows="4" placeholder="Detalii eveniment..."></textarea>
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
                <label for="event_status">Status</label>
                <select id="event_status" name="event_status">
                    <option value="ACTIV">Activ</option>
                    <option value="MONITORIZARE">Monitorizare</option>
                    <option value="REZOLVAT">Rezolvat</option>
                </select>
            </div>

            <div class="form-field">
               <div class="form-field">
                 <label for="event_county">Judet</label>
                    <select id="event_county" name="event_county" required>
                            <option value="">Selecteaza judetul</option>
                             <?php foreach ($judete as $judet): ?>
                                    <option value="<?php echo $judet; ?>">
                                             <?php echo $judet; ?>
                                    </option>
                            <?php endforeach; ?>
                     </select>
                </div>
            </div>

            <div class="form-field">
                <label for="event_city" required>Localitate</label>
                <input type="text" id="event_city" name="event_city" placeholder="ex: Suceava">
            </div>

            <div class="form-field">
                <label>Coordonate</label>
                <div class="coords-row">
                    <input type="text" name="lat" placeholder="Latitudine" required>
                    <input type="text" name="lng" placeholder="Longitudine" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-add')"> Anuleaza </button>
                <button type="button" id="modal-btn" class="btn-submit" onclick="salveazaEveniment()">Salveaza evenimentul</button> <!--id ul vine de la titlul h2 -->
            </div>

        </form>
    </div>
</div>