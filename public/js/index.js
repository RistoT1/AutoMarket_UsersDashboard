export function handleIndex() {
    const fyp_container = document.getElementById('content_container');

    function loadFyp() {
        fyp_container.innerHTML = ''; // clear old content

        fetch(`../public/api/fetchIndex.php?action=foryou`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.car_post.length === 0) {
                        fyp_container.textContent = 'No cars found.';
                        return;
                    }
                    data.car_post.forEach(car => {
                        const div = document.createElement('div');
                        div.classList.add('car-item');

                        const img = document.createElement('img');
                        img.src = `../src/uploads/${car.image_filename}`;
                        img.alt = `Image of car ${car.id}`;
                        img.style.width = '150px';

                        const info = document.createElement('p');
                        info.textContent = `Car ID: ${car.id}, Brand: ${car.brand_id}, Model: ${car.model_id}, Year: ${car.year}, Price: ${car.price}`;

                        div.appendChild(img);
                        div.appendChild(info);
                        fyp_container.appendChild(div);
                    });
                } else {
                    console.error(data.message);
                    fyp_container.textContent = 'Failed to load cars.';
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                fyp_container.textContent = 'Failed to load cars. Please try again later.';
            });
    }

    const loginBtn = document.getElementById('loginBtn');
    loginBtn.addEventListener('click', () => {
        window.location.href = 'pages/login.php';
    });

    loadFyp();
}
