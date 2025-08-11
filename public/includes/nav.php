<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="navbar-container">
        <a href="dashboard.php" class="navbar-brand">
            <svg class="navbar-brand-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M5 17h14v-2H5v2zm2.5-3h9L15 10H9l-1.5 4zM7.5 6L6 10h12L16.5 6H7.5z"/>
            </svg>
            CarMarketti
        </a>
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php if($current_page == 'dashboard.php') echo 'active'; ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="addcar.php" class="nav-link <?php if($current_page == 'addcar.php') echo 'active'; ?>">Lisää auto</a>
            </li>
        </ul>

        <div class="navbar-user">
            <button id="logoutBtn" class="btn btn-danger btn-sm">
                <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16,17 21,12 16,7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Kirjaudu ulos
            </button>
        </div>
<!-- ja eihä se mobiili toggle tietysti ole integroitu koska aika loppu :)) -->
        <button class="navbar-mobile-toggle" id="mobileToggle"> 
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>
