export const handleSignup = () => {
    const form = document.getElementById('signupForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const errorMessage = document.getElementById('error');
    const submitBtn = document.getElementById('submitBtn');
    const passwordToggle = document.getElementById('passwordToggle');

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    let triedSubmit = false;

    function validateForm() {
        const passVal = password.value;
        const confirmVal = confirmPassword.value;
        const usernameVal = username.value.trim();

        const passwordsMatch = passVal === confirmVal;
        const passwordStrong = passwordRegex.test(passVal);
        const usernameValid = usernameVal !== "";
        if (!usernameValid) {
            if (triedSubmit) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Input username';
            }
            submitBtn.disabled = true;
            return false;
        }
        else if (!passwordStrong || !passwordsMatch) {
            if (triedSubmit) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Passwords do not match or do not meet requirements.';
            }
            submitBtn.disabled = true;
            return false;
        } else {
            errorMessage.style.display = 'none';
            errorMessage.textContent = '';
            submitBtn.disabled = false;
            return true;
        }
    }

    passwordToggle.addEventListener('click', () => {
        if (password.type === 'password') {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
    });

    [username, password, confirmPassword].forEach(input => {
        input.addEventListener('input', () => {
            if (triedSubmit) {
                validateForm();
            }
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        triedSubmit = true;  // user tried submitting

        const isValid = validateForm();

        if (!isValid) {
            // Focus the first invalid input
            if (password.value !== confirmPassword.value) {
                confirmPassword.focus();
            } else if (username.value.trim() === "") {
                username.focus();
            } else {
                password.focus();
            }
            return;
        }

        // If valid, proceed with submitting form data via fetch
        const formData = new URLSearchParams(new FormData(form));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('../api/userAdd.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || 'dashboard.php';
                } else {
                    errorMessage.textContent = data.error || 'Something went wrong.';
                    errorMessage.style.display = 'block';
                }
            })
            .catch(err => {
                errorMessage.textContent = 'Network error. Please try again.';
                errorMessage.style.display = 'block';
                console.error('Fetch error:', err);
            });
    });
};
