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

                    <!-- acestea vor fi populate automat din js -->
                    <input type="hidden" name="id_incident" value="">
                    <input type="hidden" name="tip_incident" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal('modal-cap')">Anulează</button>
                        <button type="submit" class="btn-submit">Trimite alerta</button>
                    </div>

                </form>
            </div>
        </div>