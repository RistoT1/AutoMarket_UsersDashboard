// ../js/login.js
export const handleLogin = () => {
  const form = document.getElementById('loginForm');
  const errorMsg = document.getElementById('errorMsg');
  if (!form || !errorMsg) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    errorMsg.style.display = 'none';
    errorMsg.textContent = '';

    try {
      const formData = new URLSearchParams(new FormData(form));

      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      });

      const data = await response.json();

      if (data.success) {
        window.location.href = data.redirect || 'dashboard.php';
      } else {
        errorMsg.textContent = data.error || 'Login failed.';
        errorMsg.style.display = 'block';
      }
    } catch {
      errorMsg.textContent = 'Network error, please try again.';
      errorMsg.style.display = 'block';
    }
  });
};
