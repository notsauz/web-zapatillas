document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token no encontrado');
        return;
    }

    document.body.addEventListener('submit', function(event) {
        const form = event.target.closest('form.favorite-form');
        if (!form) {
            return;
        }

        event.preventDefault();

        const action = form.getAttribute('action');
        const addUrl = form.dataset.addUrl;
        const removeUrl = form.dataset.removeUrl;
        const cardSelector = form.dataset.cardSelector || '.card';
        const submitButton = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al actualizar favoritos');
            }
            return response.json().catch(() => ({}));
        })
        .then(() => {
            if (action === addUrl) {
                form.setAttribute('action', removeUrl);
                submitButton.className = 'btn btn-danger btn-sm shadow-sm';
                submitButton.innerHTML = '<i class="fas fa-heart text-white"></i>';
            } else if (action === removeUrl) {
                // Quitando de favoritos
                const isOnFavoritesPage = window.location.pathname.includes('/profile/favorites');
                
                if (isOnFavoritesPage) {
                    // Encontrar y remover la columna que contiene este producto
                    let element = form;
                    let foundColumn = null;
                    
                    // Buscar hacia arriba hasta encontrar la columna
                    while (element && element !== document.body) {
                        if (element.classList && (element.classList.contains('col-4') || 
                            element.classList.contains('col-sm-6') || 
                            element.classList.contains('col-lg-4'))) {
                            foundColumn = element;
                            break;
                        }
                        element = element.parentElement;
                    }
                    
                    // Si encontramos la columna, la removemos con animación
                    if (foundColumn) {
                        foundColumn.style.transition = 'all 0.3s ease-out';
                        foundColumn.style.opacity = '0';
                        foundColumn.style.transform = 'scale(0.95)';
                        
                        setTimeout(() => {
                            foundColumn.remove();
                        }, 300);
                    }
                } else {
                    // En el catálogo principal, solo cambiar el icono
                    form.setAttribute('action', addUrl);
                    submitButton.className = 'btn btn-outline-danger btn-sm shadow-sm';
                    submitButton.innerHTML = '<i class="far fa-heart"></i>';
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
});
