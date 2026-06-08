<nav class="navbar">
  <a href="index.php?route=login" class="logo">
    <strong>CoA</strong> <span class="dot"></span>
  </a>

  <button class="menu-toggle" id="mobile-menu-btn">
    ☰
  </button>

  <ul class="nav-links" id="nav-links">
    <li><a href="index.php?route=events-public"
          class="<?php echo (isset($active_page) && $active_page === 'events') ? 'active' : ''; ?>">Hartă & Evenimente</a>
    </li>
    <li>
      <a href="index.php?route=shelter-public"
         class="<?php echo (isset($active_page) && $active_page === 'shelters') ? 'active' : ''; ?>">Adăposturi</a>
    </li>
    <li><a href="#"
         class="<?php echo (isset($active_page) && $active_page === 'alerts') ? 'active' : ''; ?>">Alerte</a>
    </li>
    </ul>
</nav>