export const handleDashboard = () => {
  const container = document.getElementById("car_container");
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const logoutBtn = document.getElementById('logoutBtn');

  fetch(`../api/fetchDashboard.php`, {
    headers: {
      'X-CSRF-Token': csrfToken
    },
    credentials: 'include'
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        if (data.cars.length === 0) {
          container.textContent = 'No cars found.';
          return; // nothing else to do
        }
        data.cars.forEach(car => {
          const div = document.createElement('div');
          div.classList.add('car-item');

          const img = document.createElement('img');
          img.src = `../../src/uploads/${car.image_filename}`;
          img.alt = `Image of car ${car.id}`;
          img.style.width = '150px';

          const info = document.createElement('p');
          info.textContent = `Car ID: ${car.id}, Brand: ${car.brand_id}, Model: ${car.model_id}, Year: ${car.year}, Price: ${car.price}`;

          const deleteBtn = document.createElement('button');
          deleteBtn.textContent = 'Delete';

          deleteBtn.addEventListener('click', () => {
            if (!confirm('Are you sure you want to delete this car?')) return;

            fetch('../api/deleteCar.php', {
              method: 'POST',
              credentials: 'include',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
              },
              body: JSON.stringify({ car_id: car.id })
            })
              .then(res => res.json())
              .then(response => {
                if (response.success) {
                  alert('Car deleted!');
                  div.remove();
                } else {
                  alert('Delete failed: ' + (response.message || 'Unknown error'));
                }
              })
              .catch(() => alert('Network error, try again'));
          });

          div.appendChild(img);
          div.appendChild(info);
          div.appendChild(deleteBtn);
          container.appendChild(div);
        });
      } else {
        console.error(data.message);
      }
    })
    .catch(err => console.error('Fetch error:', err));

  logoutBtn.addEventListener('click', () => {
    fetch('../api/userLogout.php', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-CSRF-Token': csrfToken
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = '../pages/login.php';
        } else {
          alert('Logout failed, please try again.');
        }
      })
      .catch(() => {
        alert('Network error, please try again.');
      });
  });
};
