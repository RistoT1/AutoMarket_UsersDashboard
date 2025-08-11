<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
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
    <title>Add Car</title>
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../styles/reset.css" />
    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/carAdd.css" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/footer.css" />
</head>

<body data-page="carAdd">
    <?php include '../includes/nav.php'; ?>

    <div class="Container">
        <h2>Add a New Car</h2>

        <form id="carForm" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />

            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">🚗</span>
                    Basic Information
                </h3>

                <div class="form-group">
                    <label for="make" class="required">Car Title:</label>
                    <input type="text" id="make" name="make" placeholder="Enter car title" required />
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="brand" class="required">Brand:</label>
                        <select id="brand" name="brand_id" required>
                            <option value="">Select a brand</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="model" class="required">Model:</label>
                        <select id="model" name="model_id" required>
                            <option value="">Select a model</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="year" class="required">Year:</label>
                        <input type="number" id="year" name="year" min="1900" max="2099" placeholder="2024" required />
                    </div>

                    <div class="form-group">
                        <label for="mileage">Mileage (km):</label>
                        <input type="number" id="mileage" name="mileage" min="0" step="1" placeholder="50000" />
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">⚙️</span>
                    Technical Details
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="fuel_type" class="required">Fuel Type:</label>
                        <select id="fuel_type" name="fuel_type" required>
                            <option value="">Select fuel type</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="transmission" class="required">Transmission:</label>
                        <select id="transmission" name="transmission" required>
                            <option value="">Select transmission</option>
                            <option value="Manual">Manual</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Semi-Automatic">Semi-Automatic</option>
                            <option value="CVT">CVT</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">💰</span>
                    Pricing & Description
                </h3>

                <div class="form-group">
                    <label for="price" class="required">Price ($):</label>
                    <input type="number" id="price" name="price" min="0" step="10" placeholder="25000" required />
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description"
                        placeholder="Write detailed information about your car, including condition, features, history, etc."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">📷</span>
                    Car Image
                </h3>

                <div class="form-group">
                    <label for="carImage" class="required">Upload Image:</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="carImage" name="carImage" accept="image/*" required
                            style="display: none;" />
                        <label for="carImage" class="file-input-label">
                            <div class="file-input-icon">📁</div>
                            <div class="file-input-text">Choose car image</div>
                            <div class="file-input-subtext">JPG, PNG, GIF up to 5MB</div>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit">Add Car</button>
        </form>

        <div id="message"></div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script type="module" src="../js/main.js"></script>
</body>

</html>