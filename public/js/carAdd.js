// ../js/carAdd.js
export const handleCarAdd = () => {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');
    const form = document.getElementById('carForm');
    const messageDiv = document.getElementById('message');

    const fileInput = document.getElementById('carImage');
    const fileInputText = document.querySelector('.file-input-text');

    // Load brands from API
    function loadBrands() {
        fetch('../api/fetchCarList.php?action=brands')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.brands) {
                    data.brands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.id;
                        option.textContent = brand.name;
                        brandSelect.appendChild(option);
                    });
                } else {
                    console.error('Failed to load brands:', data.message);
                }
            })
            .catch(err => console.error('Fetch error:', err));
    }

    // Load models based on selected brand
    function loadModels(brandId) {
        modelSelect.innerHTML = '<option value="">Select a model</option>';
        if (!brandId) return;

        fetch(`../api/fetchCarList.php?action=models&brand_id=${brandId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.models) {
                    data.models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.id;
                        option.textContent = model.name;
                        modelSelect.appendChild(option);
                    });
                } else {
                    console.error('Failed to load models:', data.message);
                }
            })
            .catch(err => console.error('Fetch error:', err));
    }

    // Update file input label when file selected
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileInputText.textContent = fileInput.files[0].name;
        } else {
            fileInputText.textContent = 'Choose car image';
        }
    });

    brandSelect.addEventListener('change', e => {
        loadModels(e.target.value);
    });

    form.addEventListener('submit', e => {
        e.preventDefault();

        messageDiv.textContent = '';
        messageDiv.style.color = 'black';

        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('../api/insertCar.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-Token': csrfToken
            },
            credentials: 'include',
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    messageDiv.style.color = 'green';
                    messageDiv.textContent = 'Car added successfully!';
                    form.reset();
                    modelSelect.innerHTML = '<option value="">Select a model</option>'; // reset models as well
                    // Reset file input label text after form reset
                    fileInputText.textContent = 'Choose car image';
                } else {
                    messageDiv.style.color = 'red';
                    messageDiv.textContent = 'Error: ' + (data.error|| 'Unknown error');
                }
            })
            .catch(err => {
                messageDiv.style.color = 'red';
                messageDiv.textContent = 'Fetch error: ' + err;
                console.error('Fetch error:', err);
            });
    });

    loadBrands();
};
