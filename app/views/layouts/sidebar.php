<aside class="sidebar-layout">
    
    <div class="logo">
      <strong>CoA Admin</strong> <span class="dot"></span>
    </div>

    <nav>
            <ul class="sidebar-list">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="events.php">Evenimente</a></li>
            <li><a href="shelters.php">Adaposturi</a></li>
            <li><a href="alerts.php">Alerte CAP</a></li>
            <li><a href="users.php">Utilizatori</a></li>
            <li><a href="import-export.php">Import/Export</a></li>
        </ul>
    </nav>

    <div class="sidebar-footer" >
<!--Deconectarea schimba starea serverului-> distruge sesiunea => trebuie facut cu POST -->
      <form action="../admin/logout.php" method="POST">
         <button class="btn-logout" type="submit">Deconectare</button>
      </form>
    </div>

</aside>
