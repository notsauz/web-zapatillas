document.addEventListener('DOMContentLoaded', function() {
    // Selección de tallas
    const sizeButtons = document.querySelectorAll('.size-btn');
    const sizesInput = document.getElementById('sizes');

    // Función para actualizar el input oculto con las tallas seleccionadas
    function updateSizesInput() {
        const selected = Array.from(sizeButtons)
            .filter(btn => btn.classList.contains('active'))
            .map(btn => btn.dataset.size)
            .join(', ');
        sizesInput.value = selected;
    }

    // Agregar evento a cada botón de talla
    sizeButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            updateSizesInput();
        });
    });

    // Drag y drop para imagen de zapatilla
    const dropZone = document.getElementById('dropZone');
    const imageFile = document.getElementById('imageFile');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const clearImageBtn = document.getElementById('clearImageBtn');
    const imageUrlInput = document.getElementById('image_url');

    // Click en el dropzone abre el selector de archivos
    dropZone.addEventListener('click', () => imageFile.click());

    // Drag y drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    // Quitar clase al salir del dropzone
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    // Manejar el drop
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');

        // Obtener archivos y datos de URL
        const files = e.dataTransfer.files;
        const urlData = e.dataTransfer.getData('text/uri-list') || e.dataTransfer.getData('text/plain');
        
        // Si hay archivos, procesarlos
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                // Usar DataTransfer para asignar archivos correctamente
                const dt = new DataTransfer();
                dt.items.add(file);
                imageFile.files = dt.files;
                displayImagePreview(file);
                imageUrlInput.value = '';
            }
        }

        // Si hay URL, usarla
        else if (urlData && (urlData.startsWith('http://') || urlData.startsWith('https://'))) {
            imageUrlInput.value = urlData;
            imagePreview.src = urlData;
            imagePreviewContainer.style.display = 'block';
            imageFile.value = '';
        }
        // Si es HTML (como al arrastrar desde Google Images)
        else if (e.dataTransfer.types.includes('text/html')) {
            const html = e.dataTransfer.getData('text/html');
            const img = document.createElement('div');
            img.innerHTML = html;
            const srcMatch = html.match(/src="?([^"\s]+)"?/i);
            if (srcMatch && srcMatch[1]) {
                let imageUrl = srcMatch[1];
                // Limpiar URL si es necesario
                if (!imageUrl.startsWith('http')) {
                    imageUrl = 'https:' + imageUrl;
                }
                imageUrlInput.value = imageUrl;
                imagePreview.src = imageUrl;
                imagePreviewContainer.style.display = 'block';
                imageFile.value = '';
            }
        }
    });

    // Cambio de archivo
    imageFile.addEventListener('change', function() {
        if (this.files.length > 0) {
            displayImagePreview(this.files[0]);
            imageUrlInput.value = ''; // Limpiar URL si se sube archivo
        }
    });

    // Mostrar preview
    function displayImagePreview(file) {
        const reader = new FileReader();
        
        // Cuando la imagen se carga, mostrar el preview
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Limpiar imagen
    clearImageBtn.addEventListener('click', (e) => {
        e.preventDefault();
        imageFile.value = '';
        imagePreviewContainer.style.display = 'none';
    });

    // Si hay URL de imagen, mostrar preview
    if (imageUrlInput.value) {
        imagePreview.src = imageUrlInput.value;
        imagePreviewContainer.style.display = 'block';
    }

    // Cuando se ingresa URL, actualizar preview
    imageUrlInput.addEventListener('change', function() {
        if (this.value) {
            imagePreview.src = this.value;
            imagePreviewContainer.style.display = 'block';
            imageFile.value = ''; // Limpiar archivo si se ingresa URL
        }
    });
});
