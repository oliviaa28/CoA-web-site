 <!-- Modal trimitere alerta -->
        <div class="modal-overlay" id="modal-cap" >
            <div class="modal-card">

                <div class="modal-header">
                    <h2>Trimite alertă nouă</h2>
                    <button class="modal-close" onclick="closeModal('modal-cap')"> ✕ </button>
                </div>

                <form class="modal-form" action="/admin/alerts/store" method="POST">


                    <div class="coords-row">
                        <div class="form-field" style="flex:1">
                            <label for="cap_urgency">Urgență</label>
                            <select id="cap_urgency" name="cap_urgency" required>
                                <option value="">Selectează</option>
                                <option value="Immediate">Imediată</option>
                                <option value="Expected">În curând</option>
                                <option value="Future">In viitor</option>
                                <option value="Past">A trecut</option>
                                <option value="Unknown">Necunoscută</option>
                            </select>
                        </div>
                        <div class="form-field" style="flex:1">
                            <label for="cap_severity">Severitate</label>
                            <select id="cap_severity" name="cap_severity" required>
                                <option value="">Selectează</option>
                                <option value="Extreme">Extremă</option>
                                <option value="Severe">Gravă</option>
                                <option value="Moderate">Moderată</option>
                                <option value="Minor">Minoră</option>
                                <option value="Unknown">Nedeterminată</option>
                            </select>
                        </div>
                        <div class="form-field" style="flex:1">
                            <label for="cap_certainty">Grad de certitudine</label>
                            <select id="cap_certainty" name="cap_certainty" required>
                                <option value="">Selectează</option>
                                <option value="Observed">Confirmat</option>
                                <option value="Likely">Foarte probabil</option>
                                <option value="Possible">Posibil</option>
                                <option value="Unlikely">Puțin probabil</option>
                                <option value="Unknown">Nedeterminat</option>
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

                    <!-- acestea vor fi populate automat din js -->
                        <input type="hidden" name="id_incident" id="alert_id_incident" value="">
                        <input type="hidden" name="tip_incident" id="alert_tip_incident" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('modal-cap')">Anulează</button>
                        <button type="button" class="btn-submit" onclick="salveazaAlerta()" >Trimite alerta</button>
                    </div>

                </form>
            </div>
        </div>