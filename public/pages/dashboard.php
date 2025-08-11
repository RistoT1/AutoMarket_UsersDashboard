<?php
session_start();
// Generate CSRF token once per session if not already set 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Redirect to login if user not logged in 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <link rel="stylesheet" href="../styles/reset.css" />
    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <link rel="stylesheet" href="../styles/footer.css" />
</head>

<body data-page="dashboard">
    <?php include '../includes/nav.php'; ?>

    <header class="dashboard-header">
        <div class="container">
            <div>
                <h1 class="dashboard-title">Autosi</h1>
                <p class="dashboard-subtitle">Hallitse myynnissä olevia autojasi</p>
            </div>
            <div class="dashboard-actions">
                <a href="addcar.php" class="add-car-link">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="16" />
                        <line x1="8" y1="12" x2="16" y2="12" />
                    </svg>
                    Lisää auto
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="car-container">
        <div class="container">
            <!-- Filters -->
            <!-- <div class="dashboard-filters"> AIKA loppu niin en kerenny implementtaa tätä
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Search</label>
                        <input type="text" class="filter-input" placeholder="Search cars..." id="searchFilter">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Brand</label>
                        <select class="filter-select" id="brandFilter">
                            <option value="">All Brands</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Price Range</label>
                        <select class="filter-select" id="priceFilter">
                            <option value="">All Prices</option>
                            <option value="0-10000">$0 - $10,000</option>
                            <option value="10000-25000">$10,000 - $25,000</option>
                            <option value="25000-50000">$25,000 - $50,000</option>
                            <option value="50000+">$50,000+</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button class="filter-btn filter-btn-primary" id="applyFilters">Apply</button>
                        <button class="filter-btn" id="clearFilters">Clear</button>
                    </div>
                </div>
            </div> -->

            <!-- Loading Spinner
            <div class="loading-spinner" id="loadingSpinner" style="display: none;">
                <div class="spinner"></div>
            </div> -->

            <!-- Car Grid -->
            <div class="car-grid" id="car_container">

            </div>

            <!-- Empty State
            <div class="empty-state" id="emptyState" style="display: none;">
                <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 17h14v-2H5v2zm2.5-3h9L15 10H9l-1.5 4zM7.5 6L6 10h12L16.5 6H7.5z"/>
                </svg>
                <h3 class="empty-state-title">No cars found</h3>
                <p class="empty-state-description">
                    You haven't listed any cars yet. Start by adding your first car to the marketplace.
                </p>
                <a href="addcar.php" class="empty-state-action">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="16"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                    Add Your First Car
                </a>
            </div> -->
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script type="module" src="../js/main.js"></script>
</body>

</html>