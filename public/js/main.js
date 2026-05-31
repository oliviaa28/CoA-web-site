document.addEventListener('DOMContentLoaded', function() {
  

  const menuBtn = document.getElementById('mobile-menu-btn');
  const navLinks = document.getElementById('nav-links');

  if (menuBtn && navLinks) {
    menuBtn.addEventListener('click', function() {
      // Adaugă sau scoate clasa 'active' pentru a arăta/ascunde meniul
      navLinks.classList.toggle('active');
      
      // Schimbă iconița din Hamburger (☰) în X (✕)
      if (navLinks.classList.contains('active')) {
        menuBtn.innerHTML = '✕';
      } else {
        menuBtn.innerHTML = '☰';
      }
    });
  }

});

//pentru add event-> se deschide modular un form 


function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function openModal(id, mode) {
    document.getElementById(id).style.display = 'flex';
    
    if (mode==='edit') {
        document.getElementById('modal-title').textContent='Editeaza eveniment';
        document.getElementById('modal-btn').textContent='Salveaza modificarile';
    }else {
        document.getElementById('modal-title').textContent ='Adauga eveniment nou';
        document.getElementById('modal-btn').textContent ='Salveaza evenimentul';
    }
}

function confirmDelete(btn) {
    const td = btn.parentElement;
    td.innerHTML = `
        <div class="inline-table">
          <span >Sigur?</span>
          <a href="#" class="delete">Da </a>
          <a href="#" onclick="location.reload()">Nu</a>
        </div>
    `;
}


  function openUserModal(mode) {
            document.getElementById('modal-user').style.display = 'flex';

            if (mode === 'edit') {
                document.getElementById('modal-user-title').textContent = 'Editează utilizator';
                document.getElementById('modal-user-btn').textContent = 'Salvează modificările';
                document.getElementById('password-field').style.display = 'none';
            } else {
                document.getElementById('modal-user-title').textContent = 'Adaugă utilizator';
                document.getElementById('modal-user-btn').textContent = 'Salvează';
                document.getElementById('password-field').style.display = 'flex';
            }
        }