<nav class="navbar">
  <div class="logo">
    <strong>CoA</strong> <span class="dot"></span>
  </div>
  
  <button class="menu-toggle" id="mobile-menu-btn">
    ☰
  </button>

  <ul class="nav-links" id="nav-links">
    <li><a href="/CoA-project/app/views/public/events_public.php" class="<?php echo (isset($active_page) && $active_page === 'events') ? 'active' : ''; ?>">Hartă & Evenimente</a></li>
    <li><a href="/CoA-project/app/views/public/shelter_public.php" class="<?php echo (isset($active_page) && $active_page === 'shelters') ? 'active' : ''; ?>">Adăposturi</a></li>
    <li><a href="#" class="<?php echo (isset($active_page) && $active_page === 'alerts') ? 'active' : ''; ?>">Alerte</a></li>
    <li class="mobile-login">
      <button class="btn-login">Login</button>
    </li>
  </ul>

  <div class="desktop-login">
    <button class="btn-login">Login</button>
  </div>
</nav>