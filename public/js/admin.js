function salveazaEveniment(){

    fetch('../../../api/events.php', { //path ul din fetch e relativ la url ul paginii din browser, nu la fiserul js
        method: 'POST', 
        headers: {'Content-Type' : 'application/json'}, 
        body: JSON.stringify({
            type: document.getElementById('event_type').value, 
            titlu: document.getElementById('event_title').value, 
            descriere: document.getElementById('event_description').value, 
            localitate: document.getElementById('event_city').value,
            lat: document.querySelector('[name="lat"]').value,  //deoarece nu avem id la inputul pt lat si lng, folosim querySelector cu selector de atribut(CSS)
            lng: document.querySelector('[name="lng"]').value,
            stadiu: 'ACTIV' //nu avem in form, il setam default noi
        })
    })
    .then(response =>response.json())
    .then( data => {
        console.log('Salvat:', data);
        location.reload(); //reincarca pagina
    })
    .catch(error => {
        console.error('Eroare:' , error);
    })
}