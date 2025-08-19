<?php
include_once '../includes/session.php';
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi"></html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lisää auto</title>
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">

    <!-- CSS-tiedostot -->
    <link rel="stylesheet" href="../styles/reset.css" />
    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/carAdd.css" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/footer.css" />
</head>

<body data-page="carAdd">
    <?php include '../includes/nav.php'; ?>

    <div class="Container">
        <h2>Lisää auto</h2>

        <form id="carForm" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />

            <div class="form-section">
                <h3 class="form-section-title">
                    Perustiedot
                </h3>

                <div class="form-group">
                    <label for="make" class="required">Nimi:</label>
                    <input type="text" id="make" name="make" placeholder="Syötä auton nimi" required />
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="brand" class="required">Merkki:</label>
                        <select id="brand" name="brand_id" required>
                            <option value="">Valitse merkki</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="model" class="required">Malli:</label>
                        <select id="model" name="model_id" required>
                            <option value="">Valitse malli</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="year" class="required">Vuosimalli:</label>
                        <input type="number" id="year" name="year" min="1900" max="2099" placeholder="2024" required />
                    </div>

                    <div class="form-group">
                        <label for="mileage">Ajettu km:</label>
                        <input type="number" id="mileage" name="mileage" min="0" step="1" placeholder="50000" />
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    Tekniset tiedot
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="fuel_type" class="required">Polttoaine:</label>
                        <select id="fuel_type" name="fuel_type" required>
                            <option value="">Valitse polttoaine</option>
                            <option value="Petrol">Bensiini</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Sähkö</option>
                            <option value="Hybrid">Hybridi</option>
                            <option value="Other">Muu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="transmission" class="required">Vaihteisto:</label>
                        <select id="transmission" name="transmission" required>
                            <option value="">Valitse vaihteisto</option>
                            <option value="Manual">Manuaali</option>
                            <option value="Automatic">Automaatti</option>
                            <option value="Semi-Automatic">Puoliautomaatti</option>
                            <option value="CVT">CVT</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    Hinta & Kuvaus
                </h3>

                <div class="form-group">
                    <label for="price" class="required">Hinta €:</label>
                    <input type="number" id="price" name="price" min="0" step="10" placeholder="25000" required />
                </div>

                <div class="form-group">
                    <label for="description">Kuvaus:</label>
                    <textarea name="description" id="description"
                        placeholder="Kirjoita yksityiskohtaiset tiedot autosta, kuten kunto, varusteet, historia jne."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    Auton kuva
                </h3>

                <div class="form-group">
                    <label for="carImage" class="required">Lisää kuva:</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="carImage" name="carImage" accept="image/*" required
                            style="display: none;" />
                        <label for="carImage" class="file-input-label">
                            <div class="file-input-icon">📁</div>
                            <div class="file-input-text">Valitse auton kuva</div>
                            <div class="file-input-subtext">JPG, PNG, GIF enintään 5MB</div>
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit">Lisää auto</button>
        </form>

        <div id="message"></div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script type="module" src="../js/main.js"></script>
</body>

</html>