let toateEvenimentele = [];
let toateAdaposturile = [];
let totiUserii= [];
let toateAlertele = [];

let editId = null; //salvam info despre evenimentul pe care il editam 
let editType = null;

document.addEventListener('DOMContentLoaded', function() {
    incarcaEvenimente();
    incarcaAdaposturi(); 
    incarcaUtilizatori(); 
    incarcaAlerte();
    incarcaStatistici();

    // asculta filtrele de pe pagina de evenimente (daca exista)
    const filterTip= document.getElementById('filter_type');
    const filterStatus= document.getElementById('filter_status');
    const filterYear = document.getElementById('filter_year');
    
    if (filterYear) 
        filterYear.addEventListener('change', incarcaEvenimente);
    if (filterTip) 
        filterTip.addEventListener('change', incarcaEvenimente);
    if (filterStatus) 
        filterStatus.addEventListener('change', incarcaEvenimente);

    // verifica parametrii din URL pentru toast (dupa redirect import)
    const params = new URLSearchParams(window.location.search);

    if (params.get('success')) 
        arataToast('Import realizat cu succes!');
    else if (params.get('error') === '1') 
        arataToast('Niciun fișier selectat.', 'error');
     else if (params.get('error') === '2') 
        arataToast('Format invalid', 'error');
     else if (params.get('error') === '3') 
        arataToast('Fișierul nu corespunde tipului de eveniment', 'error');

});

//pentru protectie impotriva XSS
function curata(text) {
    //creeare div artificial
    const div= document.createElement('div');  

    //transformam textul in string si il punem in div-> daca era un script in el, acum e safe
    div.textContent = text ?? '';     
               
    return div.innerHTML;                       
}

// DOMContentLoaded asteapta ca pagina sa fie complet incarcata inainte sa apeleze functia

function arataToast(mesaj, tip ='success'){
    const container =document.getElementById('toast');
    if (!container) 
        return;

    toast.textContent = mesaj;
    toast.className= `toast toast-${tip}`; //pt stilizare
    toast.style.display = 'block';

     setTimeout(() => toast.style.display = 'none', 3000); //on cat timp dispare
}

//_________________________________________ EVENIMENTE ______________________________________

//fucntie apelata atunci cand un eveniment nou este creeat  sau editat 
function salveazaEveniment(){ //post sau put 
     const date= {
            type: document.getElementById('event_type').value, 
            titlu: document.getElementById('event_title').value, 
            descriere: document.getElementById('event_description').value, 
            localitate: document.getElementById('event_city').value,
            lat: document.querySelector('[name="lat"]').value,  //deoarece nu avem id la inputul pt lat si lng, folosim querySelector cu selector de atribut(CSS)
            lng: document.querySelector('[name="lng"]').value,
            stadiu: document.getElementById('event_status').value
     };

     let metoda, url;
     url = '../../../api/events.php';

      if(editId === null){
        metoda = 'POST';
      }
      else{
         metoda = 'PUT';
         date.id = editId;      //id ul pentru WHERE 
         date.type = editType; //tipul evenimentului editat
      }


    fetch(url, { //path ul din fetch e relativ la url ul paginii din browser(de unde apelam acesata functie), nu la fiserul js
        method: metoda, 
        headers: {'Content-Type' : 'application/json'}, 
        body: JSON.stringify(date)
    })
    .then(response =>response.json())
    .then( data => {
           arataToast('Eveniment salvat!');
            if (editId !== null) {
                actualizeazaRandEveniment(editId, editType, date);
            } else {
                incarcaEvenimente();
            }

         editId = editType = null;
         closeModal('modal-add');
    })
    .catch(error => {
        arataToast('Eroare la salvare', 'error');
        console.error('Eroare:' , error);
    })
}

function incarcaEvenimente(){

    const tbody= document.getElementById('events-tbody');
    if (!tbody) return; //cand incarcam si nu gaseste tbody, sa nu dea eroare
    tbody.innerHTML = '';

    //citim filtrele , daca exita
    let tip ='all'; //default
    let status = '';
    let year = '';

    const filterTip = document.getElementById('filter_type'); 
    const filterStatus = document.getElementById('filter_status');
    const filterYear = document.getElementById('filter_year');
    
    if (filterYear) 
        year= filterYear.value;

    if ( filterTip && filterTip.value !== '') 
        tip = filterTip.value;

    if (filterStatus) 
        status =filterStatus.value;

    let url = `../../../api/events.php?type=${tip}&status=${status}&year=${year}`;

    fetch(url)     // cere lisat de la endpoint
        .then(response => response.json() )
        .then(evenimente => { //construim html
            toateEvenimentele = evenimente; 
            tbody.innerHTML = '';
           for (let ev of evenimente) {
                tbody.innerHTML += construiesteRandEveniment(ev);
            }

        })
        .catch(error =>{
             console.error('Eroare:', error);
        });

}

function actualizeazaRandEveniment(id, type, date){

    for (let i = 0; i <toateEvenimentele.length; i++){
        if (toateEvenimentele[i].id === id && toateEvenimentele[i].type === type){

            // modificam direct campurile care s-au schimbat
            toateEvenimentele[i].title= date.titlu;
            toateEvenimentele[i].status = date.stadiu;
            toateEvenimentele[i].location = date.localitate;
            toateEvenimentele[i].details= date.descriere;
            toateEvenimentele[i].lat= date.lat;
            toateEvenimentele[i].lng= date.lng;

            // inlocuim randul din DOM
            const rand = document.getElementById(`ev-${type}-${id}`);
            if (rand) //construim din nou, d ela 0 noul rand 
                rand.outerHTML= construiesteRandEveniment(toateEvenimentele[i]);
            break;
        }
    }
}

function construiesteRandEveniment(ev){

        let badgeClass ='bg-teal'; //default

        if(ev.status){
            let s = ev.status.toLowerCase();

            if(s.includes('activ'))
                badgeClass ='bg-red';
            else if(s.includes('monitorizare'))
                 badgeClass ='bg-orange';
        }

        return ` 
         <tr  id="ev-${ev.type}-${ev.id}"> 
            <td class = "card-badges">
               <span class= "badge ${badgeClass}"> ${curata(ev.status)} </span>
            </td>
            <td>${curata(ev.type)}</td>
            <td>${curata(ev.title)}</td>
            <td>${curata(ev.location)}</td>
            <td>${curata(ev.date)}</td>
             <td class="actions">
                <a href="event-details.php?id=${ev.id}&type=${ev.type}"> Detalii</a>
                <a href="#" onclick="editeaza(${ev.id}, '${ev.type}'); return false;"> Editeaza</a>
                <a href="#" class="delete" onclick="sterge(${ev.id}, '${ev.type}'); return false;"> Sterge</a>
            </td>
         </tr>
        `;
}

function sterge(id, type){
    if (!confirm('Sigur vrei să ștergi acest eveniment?')) //returns true if the user clicked "OK", otherwise false.
         return;

    fetch(`../../../api/events.php?id=${id}&type=${type}`, { // in controller avem $id = $_GET['id']; , care ia paraemtrii din url 
        method: 'DELETE'
    })
    .then(response => response.json() )
    .then( data => {
        arataToast('Eveniment șters!');     
        const rand = document.getElementById(`ev-${type}-${id}`);
        if (rand)
             rand.remove();   // dispare doar randul
    })
    .catch(error => {
        arataToast('Eroare la ștergere', 'error');
        console.error('Eroare:' , error);
    });
}

function editeaza(id, type){
    //gasim evenimentul in lista salvata cu toate evenimentele 
    let ev= null;

    for(let e of toateEvenimentele){
        if(e.id === id && e.type === type){
            ev = e;
            break;
        }
    }

    if( ev == null) return;
    //completam campurile form ului de editare cu ce informatii avem dejAa
    document.getElementById('event_type').value = ev.type;
    document.getElementById('event_title').value = ev.title;
    document.getElementById('event_description').value = ev.details;
    document.getElementById('event_city').value = ev.location;
    document.querySelector('[name="lat"]').value = ev.lat;
    document.querySelector('[name="lng"]').value = ev.lng;
    document.getElementById('event_status').value = ev.status;

    editId= id;
    editType= type;

    //  deschidem modalul in modul edit
    openModal('modal-add', 'edit');
}

function golesteFormular() {
    editId=null; editType=null;
    document.getElementById('event_type').value = '';
    document.getElementById('event_title').value = '';
    document.getElementById('event_description').value='';
    document.getElementById('event_city').value ='';
    document.querySelector('[name="lat"]').value ='';
    document.querySelector('[name="lng"]').value = '';
    document.getElementById('event_status').value = 'ACTIV'; //default
}


//_________________________________________ ADAPOSTURI ______________________________________

function incarcaAdaposturi(){
    const tbody = document.getElementById('shelters-tbody');
    if (!tbody) return;

    fetch('../../../api/shelters.php')
    .then(response => response.json())
    .then(adaposturi => {
        toateAdaposturile = adaposturi;
        tbody.innerHTML = '';

        for (let ad of adaposturi) {
            tbody.innerHTML += construiesteRandAdapost(ad);
        }

    })
    .catch(error => console.error('Eroare:', error));

}

function construiesteRandAdapost( ad ){

     // calculam statusul si culoarea
    let badgeClass, statusText;
    if (ad.available == 0) { //am pus == in loc de === , pt ca == compaar valori indiferent de tip 
        badgeClass= 'bg-red';
        statusText = 'Plin';
    } else 
        if (ad.available < ad.capacity /2){
        badgeClass = 'bg-orange';
        statusText = 'Partial';
    } else{
        badgeClass ='bg-teal';
        statusText ='Disponibil';
    }

    return `
        <tr>
            <td>${curata(ad.name)}</td>
            <td>${curata(ad.address)}</td>
            <td>${curata(ad.type)}</td>
            <td> ${ad.available}/ ${ad.capacity}</td>
            <td> 
               <span class="badge ${badgeClass}">${statusText} </span>
            </td>
            <td class="actions">
                <a href="shelter-details.php?id=${ad.id}"> Detalii</a>
            </td>
        </tr>
    `;
     
}

function stergeAdapost(id){
    if (!confirm('Sigur vrei să ștergi acest adapost?')) return;

    fetch(`../../../api/shelters.php?id=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json() )
    .then( data => {
       arataToast('Adapost șters!');
        incarcaAdaposturi();
    })
    .catch(error => {
        arataToast('Eroare la stergerea adapostului');
        console.error('Eroare:' , error);
    });
}

function salveazaAdapost(){
    const date = {
        name: document.getElementById('shelter_name').value,
        address: document.getElementById('shelter_address').value,
        type: document.getElementById('shelter_type').value,
        lat: document.querySelector('[name="lat"]').value,
        lng: document.querySelector('[name="lng"]').value,
        capacity: document.getElementById('shelter_capacity').value,
        available: document.getElementById('shelter_available').value,
        description: document.getElementById('shelter_description').value
    };

    let metoda, url;
     url = '../../../api/shelters.php';

      if(editId === null){
        metoda = 'POST';
      }
      else{
         metoda = 'PUT';
         date.id = editId;      
      }


    fetch(url, { 
        method: metoda, 
        headers: {'Content-Type' : 'application/json'}, 
        body: JSON.stringify(date)
    })
    .then(response =>response.json())
    .then( data => {
        editId = null;
        arataToast('Adapost salvat!');
        incarcaAdaposturi();
    })
    .catch(error => {
         arataToast('Eroare la salvarea adapostului!');
        console.error('Eroare:' , error);
    });

}

function editeazaAdapost(id){ //pentru cand deschidem formularul, sa avem deja informatiile precompletate
    let s = null;

    for(let ad of toateAdaposturile) {
        if (ad.id == id){
            s= ad;
            break;
        }
    }
    
    if(s == null) 
        return ;

    document.getElementById('shelter_name').value = s.name;
    document.getElementById('shelter_address').value = s.address;
    document.getElementById('shelter_type').value = s.type;
    document.querySelector('[name="lat"]').value= s.lat;
    document.querySelector('[name="lng"]').value= s.lng;
    document.getElementById('shelter_capacity').value =s.capacity;
    document.getElementById('shelter_available').value =s.available;
    document.getElementById('shelter_description').value = s.details;  // in getAllShelters avem DESCRIERE AS "details"

 
    editId = id;
    openShelterModal('edit');
}

function golesteFormularAdapost() {
     editId=null; 
     document.getElementById('shelter_name').value = '';
     document.getElementById('shelter_address').value = '';
     document.getElementById('shelter_type').value = '';
     document.querySelector('[name="lat"]').value = '';
     document.querySelector('[name="lng"]').value = '';
     document.getElementById('shelter_capacity').value = '';
     document.getElementById('shelter_available').value = '';
    document.getElementById('shelter_description').value = '';
}

// ___________________________ USERS __________________________________

function salveazaUser(){
    const date = {
        nume: document.getElementById('user_name').value,
        email: document.getElementById('user_email').value,   // email ca username
        password: document.getElementById('user_password').value,
        judet: document.getElementById('user_county').value
        };

    let metoda, url;
     url = '../../../api/users.php';

      if(editId === null){
        metoda = 'POST';
      }
      else{
         metoda = 'PUT';
         date.id = editId;      
      }

    
    fetch(url, { 
        method: metoda, 
        headers: {'Content-Type' : 'application/json'}, 
        body: JSON.stringify(date)
    })
    .then(response =>response.json())
    .then( data => {
        
        editId = null;
        arataToast('User salvat!');
        incarcaUtilizatori();
    })
    .catch(error => {
        arataToast('Eroare la  salvare user!');
        console.error('Eroare:' , error);
    });

}

function stergeUser(id){
    if (!confirm('Sigur vrei să ștergi acest utilizator?')) return;

    fetch(`../../../api/users.php?id=${id}`, { 
        method: 'DELETE'
    })
    .then(response => response.json() )
    .then( data => {
        arataToast('User sters!');
        incarcaUtilizatori();
    })
    .catch(error => {
        arataToast('Eroare stergere user!');
        console.error('Eroare:' , error);
    });

}

function editeazaUser(id){

    let u = null;
    for (let user of totiUserii) {
        if (user.id ==id) {
            u=user;
            break;
        }
    }
    if (!u) return;

    document.getElementById('user_name').value=u.nume;
    document.getElementById('user_email').value= u.email;
    document.getElementById('user_county').value= u.judet;

    editId=id;
    openUserModal('edit');
}

function golesteFormularUseri(){
    editId=null;
    document.getElementById('user_name').value= '';
    document.getElementById('user_email').value= '';
    document.getElementById('user_county').value= '';
    document.getElementById('user_password').value= '';
}

function incarcaUtilizatori(){
    const tbody =document.getElementById('users-tbody');
    if(!tbody) return;

    fetch('../../../api/users.php')
    .then(response=>response.json())
    .then( useri => {
           totiUserii = useri;
           tbody.innerHTML = '';
           
           for (let u of useri ) {
            tbody.innerHTML += construiesteRandUser(u);
          } 

        })
    .catch(error => console.error('Eroare:', error));
}

function construiesteRandUser(u) {
    return `
        <tr>
            <td>${curata(u.nume)}</td>
            <td>${curata(u.email)}</td>
            <td>${curata(u.judet)}</td>
            <td>${curata(u.created)}</td>
            <td class="actions">
                <a href="#" onclick="editeazaUser(${u.id}); return false;">Editeaza</a>
                <a href="#" class="delete" 
                   onclick="stergeUser(${u.id}); return false;">Sterge</a>
            </td>
        </tr>
    `;
}


// ___________________________ ALERTE __________________________________

function incarcaAlerte(){
    const tbody = document.getElementById('alerts-tbody');
    if (!tbody) return;

    fetch('../../../api/alerts.php')
        .then(response => response.json())
        .then(alerte => {
            toateAlertele = alerte;
            tbody.innerHTML = '';
            for (let a of alerte) {
                tbody.innerHTML += construiesteRandAlerta(a);
            }
        })
        .catch(error => console.error('Eroare:', error));
}

function construiesteRandAlerta(a){
    let badgeClass = 'bg-teal';
    if (a.status) {
        let s = a.status.toLowerCase();
        if (s.includes('activ')) badgeClass = 'bg-red';
        else if (s.includes('monitorizare')) badgeClass = 'bg-orange';
    }

    return `
        <tr>
            <td>${curata(a.type)}</td>
            <td>${curata(a.severity)}</td>
            <td>${curata(a.sentat)}</td>
            <td><span class="badge ${badgeClass}">${a.status}</span></td>
            <td class="actions">
                <a href="cap-details.php?id=${a.id}">Detalii</a>
            </td>
        </tr>
    `;
}

function salveazaAlerta(){
    const date = {
        id_incident: document.querySelector('[name="id_incident"]').value,
        tip_incident: document.querySelector('[name="tip_incident"]').value,

        headline: document.getElementById('cap_headline').value,
        description: document.getElementById('cap_description').value,
        instruction: document.getElementById('cap_instruction').value,
        severity: document.getElementById('cap_severity').value,
        urgency: document.getElementById('cap_urgency').value,
        certainty: document.getElementById('cap_certainty').value,
        zone: document.getElementById('cap_area').value
    };

    fetch('../../../api/alerts.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(date)
    })
    .then(response => response.json())
    .then(data => {
        arataToast('Alerta trimisa!');
        incarcaAlerte();
    })
    .catch(error =>{
            arataToast('eroare trimitere alerta!');
            console.error('Eroare:', error)}
          );
}

function stergeAlerta(id){
    if (!confirm('Sigur vrei să ștergi aceasta alerta?')) return;

    fetch(`../../../api/alerts.php?id=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        arataToast('Alerta stearsa!');
        incarcaAlerte();
    })
    .catch(error =>{
            arataToast('eroare stergere alerta!');
            console.error('Eroare:', error)}
          );
}


// _______________________________ DASH BOARD -> statistici ______________________________________


function incarcaStatistici() {

    //verificam daca suntem in pagina dashboard
    const cardEvenimente = document.getElementById('stat-evenimente');
    if(!cardEvenimente)
        return;

    //evenimente active 
    fetch('../../../api/events.php?status=activ')
     .then(response => response.json())
     .then( evenimente =>{ 
         cardEvenimente.textContent = evenimente.length;} // length = nr de elemente din array
     );

     //alerte
    fetch('../../../api/alerts.php')
      .then(response => response.json())
       .then(alerte => {
            document.getElementById('stat-alerte').textContent = alerte.length;
        });

    //adaposturi disponibile 
    fetch('../../../api/shelters.php')
       .then(response => response.json())
       .then(adaposturi => {
           let nr=0;
           for( let a of adaposturi)
              if( a.available > 0 )// datele returnate de api 
                nr++;

            document.getElementById('stat-adaposturi').textContent = nr;
        });

    fetch('../../../api/users.php')
      .then(response => response.json())
       .then(users => {
           document.getElementById('stat-utilizatori').textContent = users.length;
        });



}

//____________________ import export _________________________

function exportData(type, format){
    arataToast('Se descarcă fișierul...');
    //relativ la url ul paginii import-export.php din admin
    window.location.href= `../../../api/import-export.php?action=export&type=${type}&format=${format}`;
}