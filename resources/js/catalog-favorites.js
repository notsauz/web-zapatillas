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
                form.setAttribute('action', addUrl);
                submitButton.className = 'btn btn-outline-danger btn-sm shadow-sm';
                submitButton.innerHTML = '<i class="far fa-heart"></i>';
                if (window.location.pathname.includes('/profile/favorites')) {
                    const card = form.closest(cardSelector);
                    if (card) {
                        card.remove();
                    }
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
});
