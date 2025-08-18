<?php
include_once 'session.php';
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$current_page = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['user_id']);

// Determine if we're in the pages folder
$in_pages_folder = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
?>
<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
<nav class="navbar">
    <div class="navbar-container">
        <?php if ($in_pages_folder): ?>
            <a href="../index.php" class="navbar-brand">CarMarketti</a>
        <?php else: ?>
            <a href="./index.php" class="navbar-brand">CarMarketti</a>
        <?php endif; ?>

        <ul class="navbar-nav">
            <?php if ($isLoggedIn && $current_page != "index.php"): ?>
                <li class="nav-item">
                    <?php if ($in_pages_folder): ?>
                        <a href="./dashboard.php"
                            class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                    <?php else: ?>
                        <a href="./pages/dashboard.php"
                            class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if ($in_pages_folder): ?>
                        <a href="./addcar.php" class="nav-link <?= $current_page == 'addcar.php' ? 'active' : '' ?>">Lisää auto</a>
                    <?php else: ?>
                        <a href="./pages/addcar.php" class="nav-link <?= $current_page == 'addcar.php' ? 'active' : '' ?>">Lisää auto</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>

        <div class="navbar-user">
            <?php if ($isLoggedIn): ?>
                <button id="logoutBtn" class="btn btn-danger btn-sm">Kirjaudu ulos</button>
            <?php else: ?>
                <button id="loginBtn" class="btn btn-sm">Kirjaudu</button>
            <?php endif; ?>
        </div>

        <button class="navbar-mobile-toggle" id="mobileToggle">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginBtn = document.getElementById('loginBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const brand = document.querySelector(".navbar-brand");

        // Detect if we're in pages folder
        const inPagesFolder = window.location.pathname.includes('/pages/');

        brand.addEventListener('click', e => {
            e.preventDefault();
            if (window.location.pathname.split('/').pop() !== 'index.php') {
                if (inPagesFolder) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = './index.php';
                }
            }
        });

        if (loginBtn) {
            loginBtn.addEventListener('click', () => {
                if (inPagesFolder) {
                    window.location.href = './login.php';
                } else {
                    window.location.href = './pages/login.php';
                }
            });
        }

        if (logoutBtn) {
            logoutBtn.addEventListener('click', async () => {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // API path depends on current location
                    const apiPath = inPagesFolder ? '../api/userLogout.php' : './api/userLogout.php';

                    const res = await fetch(apiPath, {  
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': csrfToken
                        }
                    });

                    const responseText = await res.text();

                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (parseError) {
                        console.error('JSON Parse Error:', parseError);
                        console.error('Response was not JSON. Full response:', responseText);
                        alert('Server returned an error. Check console for details.');
                        return;
                    }

                    if (data.success) {
                        // Always redirect to main index after logout
                        if (inPagesFolder) {
                            window.location.href = '../index.php';
                        } else {
                            window.location.href = './index.php';
                        }
                    } else {
                        alert(data.message || 'Logout failed.');
                    }
                } catch (err) {
                    console.error('Logout error:', err);
                    alert('Network error. Try again.');
                }
            });
        }
    });
</script>