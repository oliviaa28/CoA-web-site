<aside class="sidebar-layout">
    
    <a href="index.php?route=documentation" class="logo">
      <strong>CoA Admin</strong> <span class="dot"></span>
    </a>

    <nav>
            <ul class="sidebar-list">
            <li><a href="index.php?route=dashboard">Dashboard</a></li>
            <li><a href="index.php?route=events">Evenimente</a></li>
            <li><a href="index.php?route=shelters">Adaposturi</a></li>
            <li><a href="index.php?route=alerts">Alerte </a></li>
            <li><a href="index.php?route=users">Utilizatori</a></li>
            <li><a href="index.php?route=import-export">Import/Export</a></li>
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
