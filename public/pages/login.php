<?php 
include_once '../includes/session.php';
if (empty($_SESSION['csrf_token'])) {     
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Car Marketplace</title>
    <link rel="stylesheet" href="../styles/reset.css" />
    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/login.css" />
</head>
<body data-page="login">
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <svg class="login-logo" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 17h14v-2H5v2zm2.5-3h9L15 10H9l-1.5 4zM7.5 6L6 10h12L16.5 6H7.5z"/>
                </svg>
            </div>
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to your account</p>
        </div>

        <div class="login-form">
            <div id="errorMsg" class="login-message error" style="display:none;"></div>

            <form id="loginForm" class="login-form" action="../api/loginCheck.php" method="post" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
                
                <div class="login-form-group">
                    <label for="username" class="login-form-label">Username</label>
                    <div class="login-input-wrapper">
                        <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input 
                            id="username"
                            class="login-form-input with-icon" 
                            type="text" 
                            name="user" 
                            required 
                            placeholder="Enter your username"
                            autocomplete="username"
                        />
                    </div>
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-wrapper">
                        <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <circle cx="12" cy="16" r="1"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input 
                            id="password"
                            class="login-form-input with-icon" 
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Enter your password"
                            autocomplete="current-password"
                        />
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <svg class="password-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="remember-me-wrapper">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" class="checkbox-input" />
                        <label for="remember" class="checkbox-label">Remember me</label>
                    </div>
                    <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    Sign In
                </button>
            </form>
        </div>

        <div class="signup-link-wrapper">
            <p class="signup-link-text">Don't have an account?</p>
            <a href="signup.php" class="signup-link">Create an account</a>
        </div>
    </div>

    <script type="module" src="../js/main.js"></script>
</body>
</html>