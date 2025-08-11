// ../js/main.js
const pageModules = {
  login: () => import('./login.js').then(m => m.handleLogin()),
  dashboard: () => import('./dashboard.js').then(m => m.handleDashboard()),
    signup: () => import('./signup.js').then(m => m.handleSignup()),
    carAdd: () => import('./carAdd.js').then(m => m.handleCarAdd()),
};

const init = () => {
  const page = document.body.getAttribute('data-page');
  const loadPageModule = pageModules[page];

  if (loadPageModule) {
    loadPageModule();
  } else {
    console.log('No JS module found for page:', page);
  }
};

document.addEventListener('DOMContentLoaded', init);
