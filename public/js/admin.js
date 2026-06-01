let toateEvenimentele = [];
let toateAdaposturile = [];

let editId = null; //salvam info despre evenimentul pe care il editam 
let editType = null;

document.addEventListener('DOMContentLoaded', function() {
    incarcaEvenimente();
    incarcaAdaposturi(); 
});

// DOMContentLoaded asteapta ca pagina sa fie complet incarcata inainte sa apeleze functia

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
            stadiu: 'ACTIV' //nu avem in form, setam default 
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
        console.log('Salvat:', data);
        editId = editType = null;
        location.reload(); //reincarca pagina
    })
    .catch(error => {
        console.error('Eroare:' , error);
    })
}

function incarcaEvenimente(){

    const tbody= document.getElementById('events-tbody');
    if (!tbody) return; //cand incarcam si nu gaseste tbody, sa nu dea eroare
    tbody.innerHTML = '';

    fetch('../../../api/events.php')     // cere lisat de la endpoint
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
         <tr>
            <td class = "card-badges">
               <span class= "badge ${badgeClass}"> ${ev.status} </span>
            </td>
            <td>${ev.type}</td>
            <td>${ev.title}</td>
            <td>${ev.location}</td>
            <td>${ev.date}</td>
             <td class="actions">
                <a href="event-details.php?id=${ev.id}&type=${ev.type}"> Detalii</a>
                <a href="#" onclick="editeaza(${ev.id}, '${ev.type}'); return false;"> Editeaza</a>
                <a href="#" class="delete" onclick="sterge(${ev.id}, '${ev.type}'); return false;"> Sterge</a>
            </td>
         </tr>
        `;
}

function sterge(id, type){

    fetch(`../../../api/events.php?id=${id}&type=${type}`, { // in controller avem $id = $_GET['id']; , care ia paraemtrii din url 
        method: 'DELETE'
    })
    .then(response => response.json() )
    .then( data => {
        console.log('Sters:', data);
        location.reload(); //reincarca pagina
    })
    .catch(error => {
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
            <td>${ad.name}</td>
            <td>${ad.address}</td>
            <td>${ad.type}</td>
            <td> ${ad.available}/ ${ad.capacity}</td>
            <td> 
               <span class="badge ${badgeClass}">${statusText} </span>
            </td>
            <td class="actions">
                <a href="shelter-details.php?id=${ad.id}"> Detalii</a>
                <a href="#" onclick=" editeazaAdapost( ${ad.id} ); return false;"> Editeaza</a>
                <a href="#" class="delete" onclick="stergeAdapost(${ad.id}); return false;">Sterge</a>
            </td>
        </tr>
    `;
     
}

function stergeAdapost(id){

    fetch(`../../../api/shelters.php?id=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json() )
    .then( data => {
        console.log('Sters:', data);
        location.reload(); 
    })
    .catch(error => {
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
        console.log('Salvat:', data);
        editId = null;
        location.reload(); //reincarca pagina
    })
    .catch(error => {
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