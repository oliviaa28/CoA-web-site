// JS pentru paginile de detalii(adaposturi, evenimente, alerte )din ADMIN

let adapostCurentId = null;
let evenimentCurentId = null;
let evenimentCurentType = null;
let alertaCurentaId= null;


//fiecare fucntie ruleaza doar pe pagina ei
document.addEventListener('DOMContentLoaded', function() {
    incarcaDetaliiAdapost();
    incarcaDetaliiEveniment();
    incarcaDetaliiAlerta();
});

function getIdFromUrl(){
    const param= new URLSearchParams( window.location.search );
    return param.get('id');
}

// ______________________________ adapost page ______________________________ 

function incarcaDetaliiAdapost(){

    const nume = document.getElementById('shelter-name');
    if(nume== null)
        return;

    const id = getIdFromUrl();
    if(id== null)
        return;

    adapostCurentId = id;

    fetch(`index.php?route=api/shelters&id=${id}`)
        .then(r => r.json())
        .then( s=> {
            document.getElementById('shelter-name').textContent= s.name;
            document.getElementById('shelter-type').textContent= s.type;
            document.getElementById('shelter-address-header').textContent = s.address;
            document.getElementById('shelter-address').textContent= s.address;
            document.getElementById('shelter-capacity').textContent=s.capacity;
            document.getElementById('shelter-available').textContent =s.available;
            document.getElementById('shelter-description').textContent = s.details;
        
            const badge = document.getElementById('shelter-badge');

            if (s.available == 0){
                badge.textContent= 'PLIN';
                badge.className ='badge bg-red';
            } 
            else if (s.available < s.capacity / 2){
                badge.textContent='PARTIAL';
                 badge.className = 'badge bg-orange';
            } else{
                badge.textContent='DISPONIBIL';
                badge.className = 'badge bg-teal';
            }
            
            // --- HARTĂ INTERACTIVĂ ADĂPOST ---
            const mapContainer = document.getElementById('shelter-map');
            if (mapContainer && s.lat && s.lng) {
                const lat = parseFloat(s.lat);
                const lng = parseFloat(s.lng);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    if (window.shelterMap !== undefined) {
                        window.shelterMap.remove();
                    }
                    
                    window.shelterMap = L.map('shelter-map').setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(window.shelterMap);
                    
                    L.marker([lat, lng]).addTo(window.shelterMap)
                        .bindPopup(`<b>${s.name}</b><br>${s.address}`).openPopup();
                }
            }
        })
        .catch(error => console.error('Eroare:', error));
       
}

function stergeAdapostDetalii() {
    if ( !confirm('Sigur vrei să ștergi acest adăpost?'))
         return;

    fetch(`index.php?route=api/shelters&id=${adapostCurentId}`,{
        method: 'DELETE'
    })
    .then(r => r.json())
    .then(data => {
        window.location.href = 'index.php?route=shelters';  // dupa stergere, mergem al list acu adaposturi 
    })
    .catch(error => console.error('Eroare:', error));
}

function editeazaAdapostDetalii() {
    
    fetch(`index.php?route=api/shelters&id=${adapostCurentId}`)
        .then(r => r.json())
        .then(s => {
            document.getElementById('shelter_name').value= s.name;
            document.getElementById('shelter_address').value= s.address;
            document.getElementById('shelter_type').value= s.type;

            document.querySelector('[name="lat"]').value= s.lat;
            document.querySelector('[name="lng"]').value= s.lng;
            document.getElementById('shelter_capacity').value= s.capacity;
            document.getElementById('shelter_available').value= s.available;
            document.getElementById('shelter_description').value= s.details;

            //editId si openShelterModal sunt din main.js
            editId = adapostCurentId;    // pentru ca salveazaAdapost sa faca PUT
            openShelterModal('edit');
        });
}



// _____________________________ EVENT DETAIL __________________________________

function incarcaDetaliiEveniment() {
    const nume = document.getElementById('event-name');
    if (!nume) 
        return;

    const id = getIdFromUrl();

    const param= new URLSearchParams(window.location.search);
    const type= param.get('type');

    if(id ==null || type==null)
      return;

    evenimentCurentId = id;
    evenimentCurentType = type;

    fetch(`index.php?route=api/events&id=${id}&type=${type}`)
    .then(r =>r.json())
    .then( e => {
            
            // numele coloanelor sunt DIN DB (titlu, stadiu) pt ca getEventDetails face SELECT *
            document.getElementById('event-name').textContent= e.titlu;
            document.getElementById('event-address-header').textContent= e.localitate;

            // descriere 
            const descriere = document.querySelector('.detail-panel p'); //descrierea este intr un paragraf (p) si nu i am mai dat id, asa ca selectez cu selectorii css
            if( descriere) 
                descriere.textContent= e.descriere;

            // badge status (rosu, potrtocaliu,...)
            const badge = document.getElementById('event-badge');
            badge.textContent = e.stadiu;

            let s= e.stadiu.toLowerCase();
            if (s.includes('activ')) 
                badge.className='badge bg-red';
            else 
               if (s.includes('monitorizare')) 
                 badge.className= 'badge bg-orange';
            else 
                badge.className= 'badge bg-teal';

            // --- HARTĂ INTERACTIVĂ ---
            const mapContainer = document.getElementById('event-map');
            if (mapContainer && e.latitudine && e.longitudine) {
                const lat = parseFloat(e.latitudine);
                const lng = parseFloat(e.longitudine);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    if (window.eventMap !== undefined) {
                        window.eventMap.remove();
                    }
                    
                    window.eventMap = L.map('event-map').setView([lat, lng], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(window.eventMap);
                    
                    L.marker([lat, lng]).addTo(window.eventMap)
                        .bindPopup(`<b>${e.titlu}</b><br>${e.localitate}`).openPopup();
                }
            }
          }
         );
    
    incarcaAlerteEveniment(); // trebuie apelata dupa ce evenimentCurentId +  evenimentCurentType sunt setate
}

function stergeEvenimentDetalii(){
      if ( !confirm('Sigur vrei să ștergi acest eveniment?'))
         return;

    fetch(`index.php?route=api/events&id=${evenimentCurentId}&type=${evenimentCurentType}`,{
        method: 'DELETE'
    })
    .then(r => r.json())
    .then(data => {
        window.location.href = 'index.php?route=events'; 
    })
    .catch(error => console.error('Eroare:', error));
}

function editeazaEvenimentDetalii(){

    fetch(`index.php?route=api/events&id=${evenimentCurentId}&type=${evenimentCurentType}`)
        .then(r => r.json())
        .then(e => {
            document.getElementById('event_type').value= evenimentCurentType;
            document.getElementById('event_title').value= e.titlu;
            document.getElementById('event_description').value=e.descriere;
            document.getElementById('event_city').value= e.localitate;
            document.querySelector('[name="lat"]').value= e.latitudine;
            document.querySelector('[name="lng"]').value= e.longitudine;
            document.getElementById('event_status').value= e.stadiu;

            editId= evenimentCurentId;
            editType=evenimentCurentType;

            openModal('modal-add', 'edit');
        });

}

function deschideAlertaDinEveniment() {
     // completeaza inputurile hidden (din form) cu info despre evenimentul curent
    document.querySelector('[name="id_incident"]').value= evenimentCurentId;
    document.querySelector('[name="tip_incident"]').value=evenimentCurentType;
    
    document.getElementById('modal-cap').style.display = 'flex';
}

function incarcaAlerteEveniment(){

    const tbody = document.querySelector('.alerts-section tbody');
    
    if (!tbody) 
        return;
    if (!evenimentCurentId) 
        return;

    fetch(`index.php?route=api/alerts&id_incident=${evenimentCurentId}&tip_incident=${evenimentCurentType}`)
        .then(r => r.json())
        .then(alerte => {
            tbody.innerHTML = '';
            for (let a of alerte) 
            {
                tbody.innerHTML += `
                    <tr>
                        <td>${a.headline}</td>
                        <td>${a.severity}</td>
                        <td>${a.sentat}</td>
                        <td><span class="badge bg-red">${a.status}</span></td>
                        <td><a href="index.php?route=cap-details&id=${a.id}" class="btn-link">Detalii</a></td>
                    </tr>
                `;
            }
        })
        .catch(error => console.error('Eroare:', error));
}

// ___________________________ ALERT DETAIL PAGE ____________________________________


function incarcaDetaliiAlerta() {
    const nume = document.getElementById('alert-detail-headline');
    if (!nume) 
        return;

    const id=getIdFromUrl();
    if (!id)
       return;

    alertaCurentId = id;

    fetch(`index.php?route=api/alerts&id=${id}`)
        .then(r => r.json())
        .then(a => {
            document.getElementById('alert-detail-headline').textContent = a.headline;
            document.getElementById('alert-sent').textContent='Trimis: '+ a.sentat;
            document.getElementById('alert-severity').textContent =a.severity;
            document.getElementById('alert-urgency').textContent =a.urgency;
            document.getElementById('alert-area').textContent= a.zone;
            document.getElementById('alert-description').textContent=a.description;
            document.getElementById('alert-instruction').textContent =a.instruction;

            const badge = document.getElementById('alert-badge');
            badge.textContent =a.status;

            let s = a.status.toLowerCase();
            
            if (s.includes('activ')) 
                badge.className = 'badge bg-red';
            else 
                badge.className = 'badge bg-teal';

            // eveniment asociat
            const eventInfo = document.getElementById('alert-event-info');
            const eventLink = document.getElementById('alert-event-link');
           
            if (a.incidentid && a.type) {
                eventInfo.textContent = `Tip: ${a.type}`;
                eventLink.href= `index.php?route=event-details&id=${a.incidentid}&type=${a.type}`;
            } else {
                eventInfo.textContent='Fără eveniment asociat';
                eventLink.style.display='none';
            }   
        })
        .catch(error => console.error('Eroare:', error));
}

function anuleazaAlerta(){

    if ( !confirm('Sigur vrei să anulezi această alertă?')) 
        return;

    fetch(`index.php?route=api/alerts&id=${alertaCurentId}`, {
        method: 'DELETE'
    })
    .then(r =>r.json())
    .then(data =>{ window.location.href = 'index.php?route=alerts'; }
    )
    .catch(error => console.error('Eroare:', error));

}

function exportaAlerta() { 
    //navigheaza la endpoint, care va raspunde cu headers pt descarcare
    window.location.href= `index.php?route=api/alerts&action=export&id=${alertaCurentId}`;
}