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
    <title>Sign Up - Car Marketplace</title>
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <link rel="stylesheet" href="../styles/reset.css" />
    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/signup.css" />
</head>
<body data-page="signup">
    <div class="signup-container">
        <div class="signup-header">
            <div class="signup-logo">
                <svg class="signup-logo" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 17h14v-2H5v2zm2.5-3h9L15 10H9l-1.5 4zM7.5 6L6 10h12L16.5 6H7.5z"/>
                </svg>
            </div>
            <h1 class="signup-title">Join Car Marketplace</h1>
            <p class="signup-subtitle">Create your account to get started</p>
        </div>

        <div class="signup-form">
            <div class="signup-progress">
                <div class="progress-step active">
                    <div class="progress-step-number">1</div>
                    <div class="progress-step-label">Account</div>
                </div>
                <div class="progress-step">
                    <div class="progress-step-number">2</div>
                    <div class="progress-step-label">Profile</div>
                </div>
                <div class="progress-step">
                    <div class="progress-step-number">3</div>
                    <div class="progress-step-label">Complete</div>
                </div>
            </div>


            <form id="signupForm" class="signup-form" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>" />
                
                <div class="signup-form-section">
                    <div class="signup-form-section-title">
                        <svg class="signup-form-section-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Account Information
                    </div>

                    <div class="signup-form-group">
                        <label for="username" class="signup-form-label required">Username</label>
                        <div class="signup-input-wrapper">
                            <svg class="signup-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input 
                                id="username" 
                                class="signup-form-input with-icon" 
                                type="text" 
                                name="username" 
                                required 
                                autocomplete="username"
                                placeholder="Choose a unique username"
                            />
                        </div>
                    </div>

                    <div class="signup-form-group">
                        <label for="password" class="signup-form-label required">Password</label>
                        <div class="signup-input-wrapper">
                            <svg class="signup-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <circle cx="12" cy="16" r="1"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input 
                                id="password" 
                                class="signup-form-input with-icon" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="Create a strong password"
                            />
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <svg class="password-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar">
                                <div class="password-strength-fill" id="passwordStrengthFill"></div>
                            </div>
                            <div class="password-strength-text" id="passwordStrengthText">Password strength</div>
                        </div>
                        <div id="passwordInfo" class="field-warning-message" style="display:block;">
                            Minimum 8 characters, including uppercase, lowercase, number, and special character.
                        </div>
                    </div>

                    <div class="signup-form-group">
                        <label for="confirm-password" class="signup-form-label required">Confirm Password</label>
                        <div class="signup-input-wrapper">
                            <svg class="signup-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input 
                                id="confirm-password" 
                                class="signup-form-input with-icon" 
                                type="password" 
                                name="confirm_password" 
                                required 
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                            />
                        </div>
                    </div>
                </div>

                <button type="submit" class="signup-btn" id="submitBtn">
                    Create Account
                </button>
            </form>
        </div>

        <div id="error" class="signup-message error" style="display:none;"></div>

        <div class="login-link-wrapper">
            <p class="login-link-text">Already have an account?</p>
            <a href="login.php" class="login-link">Sign in here</a>
        </div>
    </div>

    <script type="module" src="../js/main.js"></script>
</body>
</html>