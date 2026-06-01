let toateEvenimentele = [];
let editId = null; //salvam info despre evenimentul pe care il editam 
let editType = null;

document.addEventListener('DOMContentLoaded', function() {
    incarcaEvenimente();
});

// DOMContentLoaded asteapta ca pagina sa fie complet incarcata inainte sa apeleze functia

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


    fetch('../../../api/events.php', { //path ul din fetch e relativ la url ul paginii din browser(de unde apelam acesata functie), nu la fiserul js
        method: 'POST', 
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
    tbody.innerHTML = '';

    fetch('../../../api/events.php')     // cere lisat de la endpoint
        .then(response => response.json() )
        .then(evenimente => { //construim html
            toateEvenimentele = evenimente; 
            tbody.innerHTML = '';
           for (let ev of evenimente) {
                tbody.innerHTML += construiesteRand(ev);
            }

        })
        .catch(error =>{
             console.error('Eroare:', error);
        });

}

function construiesteRand(ev){
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