<aside class="sidebar-layout">
    
    <div class="logo">
      <strong>CoA Admin</strong> <span class="dot"></span>
    </div>

    <nav>
            <ul class="sidebar-list">
            <li><a href="dashboard.php?route=dashbord">Dashboard</a></li>
            <li><a href="events.php?route=events">Evenimente</a></li>
            <li><a href="shelters.php?route=shelters">Adaposturi</a></li>
            <li><a href="alerts.php?route=alerts">Alerte </a></li>
            <li><a href="users.php?route=users">Utilizatori</a></li>
            <li><a href="import-export.php?route=import-export">Import/Export</a></li>
        </ul>
    </nav>  

    <div class="sidebar-footer" >
<!--Deconectarea schimba starea serverului-> distruge sesiunea => trebuie facut cu POST -->
      <form action="index.php?route=api/logout" method="POST">
         <button class="btn-logout" type="submit">Deconectare</button>
      </form>
    </div>

</aside>

<!-- container pentru notificari toast-->
<div id="toast" class="toast" style="display:none;"></div>
