document.addEventListener('DOMContentLoaded', function () {
    // Drag y drop para logo de marca
    const dropZone = document.getElementById('dropZone');
    const logoFile = document.getElementById('logoFile');
    const logoPreview = document.getElementById('logoPreview');
    const logoPreviewContainer = document.getElementById('logoPreviewContainer');
    const clearLogoBtn = document.getElementById('clearLogoBtn');
    const logoUrlInput = document.getElementById('logo_url');

    // Click en el dropzone abre el selector de archivos
    dropZone.addEventListener('click', () => logoFile.click());

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
                logoFile.files = dt.files;
                displayLogoPreview(file);
                logoUrlInput.value = '';
            }
        }
        // Si hay URL, usarla
        else if (urlData && (urlData.startsWith('http://') || urlData.startsWith('https://'))) {
            logoUrlInput.value = urlData;
            logoPreview.src = urlData;
            logoPreviewContainer.style.display = 'block';
            logoFile.value = '';
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
                logoUrlInput.value = imageUrl;
                logoPreview.src = imageUrl;
                logoPreviewContainer.style.display = 'block';
                logoFile.value = '';
            }
        }
    });

    // Cambio de archivo
    logoFile.addEventListener('change', function () {
        if (this.files.length > 0) {
            displayLogoPreview(this.files[0]);
            logoUrlInput.value = '';
        }
    });

    // Mostrar preview
    function displayLogoPreview(file) {
        
        // Validar que sea una imagen
        const reader = new FileReader();

        // Cuando la imagen se carga, mostrar el preview
        reader.onload = (e) => {
            logoPreview.src = e.target.result;
            logoPreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Limpiar logo
    clearLogoBtn.addEventListener('click', (e) => {
        e.preventDefault();
        logoFile.value = '';
        logoPreviewContainer.style.display = 'none';
    });

    // Si hay URL de logo, mostrar preview
    if (logoUrlInput.value) {
        logoPreview.src = logoUrlInput.value;
        logoPreviewContainer.style.display = 'block';
    }

    // Cuando se ingresa URL, actualizar preview
    logoUrlInput.addEventListener('change', function () {
        if (this.value) {
            logoPreview.src = this.value;
            logoPreviewContainer.style.display = 'block';
            logoFile.value = '';
        }
    });
});
