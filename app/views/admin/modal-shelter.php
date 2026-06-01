<!-- Modal pentru adaugare sau editare adaposturi -->
<div class = "modal-overlay" id="modal-shelter"  >
    <div class ="modal-card">

         <div class="modal-header">
            <h2 id="modal-shelter-title">Adauga adapost</h2>
                <button class="modal-close" onclick="closeModal('modal-shelter')"> X </button>
          </div>

           <form class="modal-form" action="/admin/shelters/store" method="POST">

                <div class="form-field">
                    <label for="shelter_name">Nume</label>
                    <input type="text" id="shelter_name" name="shelter_name"
                            placeholder="ex: Scoala Gimnaziala Ion Creanga" required>
                </div>
                <div class="form-field">
                    <label for="shelter_address">Adresa</label>
                    <input type="text" id="shelter_address" name="shelter_address"
                            placeholder="ex: Str. Vasile Lupu nr. 78, Iasi" required>
                </div>

                <div class="coords-row">
                    <div class="form-field">
                        <label for="shelter_type"> Tip adapost </label>
                        <select id="shelter_type" name="shelter_type" required>
                                <option value="">Selecteaza</option>
                                <option value="Buncar">Buncar</option>
                                <option value="Punct Medical">Punct Medical</option>
                                <option value="Provizii">Provizii</option>
                        </select>
                    </div>

                    <div class="form-field" >
                        <label for="shelter_capacity">Capacitate totala</label>
                        <input type="text" id="shelter_capacity" name="shelter_capacity" placeholder="ex: 350" required>
                    </div>

                    <div class="form-field" >
                        <label for="shelter_available">Locuri disponibile</label>
                        <input type="text" id="shelter_available" name="shelter_available" placeholder="ex: 280" required>
                    </div>

                </div>
            
                <div class="form-field">
                    <label>Coordonate</label>
                        <div class="coords-row">
                            <input type="text" name="lat" placeholder="Latitudine">
                            <input type="text" name="lng" placeholder="Longitudine">
                        </div>
                </div>
 
                <div class="form-field">
                    <label for="shelter_description">Descriere</label>
                    <textarea id="shelter_description" name="shelter_description" rows="3"  placeholder="Detalii despre adapost..."></textarea>
                </div>
 
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-shelter')">Anuleaza</button>
                    <button type="button" id="modal-shelter-btn" onclick="salveazaAdapost()" >Salveaza</button>
                </div>
 
         </form>

    </div>
</div>