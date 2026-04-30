// Obtener el token CSRF del meta tag para las peticiones POST
let tokenCSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (!tokenCSRF) {
    console.error('CSRF token no encontrado');
}

function refreshTopFavoritesSection() {
    let topFavoritesSection = document.getElementById('topFavoritesSection');
    if (!topFavoritesSection) {
        return;
    }

    let url = topFavoritesSection.dataset.url;
    if (!url) {
        return;
    }

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'Cache-Control': 'no-cache'
        },
        cache: 'no-store'
    })
        .then(response => response.json())
        .then(json => {
            if (json.html) {
                topFavoritesSection.outerHTML = json.html;
            }
        })
        .catch(error => {
            console.error('Error al actualizar sección de Más Favoritas:', error);
        });
}

// Escuchar todos los envíos de formularios de favoritos
document.body.addEventListener('submit', function (evento) {
    // Buscar si el formulario enviado es de favoritos
    let formulario = evento.target.closest('form.favorite-form');
    if (!formulario) {
        return; // No es un formulario de favoritos, seguir con el envío normal
    }

    // Prevenir el envío tradicional del formulario
    evento.preventDefault();

    // Obtener datos del formulario
    let accionActual = formulario.getAttribute('action'); // URL actual (agregar o eliminar)
    let urlAgregarFavorito = formulario.dataset.addUrl; // URL para agregar a favoritos
    let urlEliminarFavorito = formulario.dataset.removeUrl; // URL para eliminar de favoritos
    let selectorTarjetaProducto = formulario.dataset.cardSelector || '.card'; // Selector de la tarjeta del producto
    let botonEnviar = formulario.querySelector('button[type="submit"]'); // Botón de envío
    let datosFormulario = new FormData(formulario); // Datos del formulario (sneaker_id)

    // Enviar petición AJAX para agregar/eliminar favorito
    fetch(accionActual, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF,
            'Accept': 'application/json'
        },
        body: datosFormulario,
    })
        .then(respuesta => respuesta.json().catch(() => ({}))) // Convertir a JSON, si falla devolver objeto vacío
        .then(datos => {
            // Verificar si la acción era AGREGAR a favoritos
            let esAccionAgregar = accionActual === urlAgregarFavorito;

            if (esAccionAgregar) {
                // Cambiar el formulario para que ahora sea ELIMINAR
                formulario.setAttribute('action', urlEliminarFavorito);
                // Cambiar estilo del botón a rojo (favorito activo)
                botonEnviar.className = 'btn btn-danger btn-sm shadow-sm';
                botonEnviar.innerHTML = '<i class="fas fa-heart text-white"></i>';
            } else {
                // La acción era ELIMINAR de favoritos
                let estaEnPaginaFavoritos = window.location.pathname.includes('/profile/favorites');

                if (estaEnPaginaFavoritos) {
                    // Estamos en la página de favoritos, hay que eliminar la tarjeta del DOM
                    let elementoActual = formulario;
                    let columnaProducto = null;

                    // Buscar hacia arriba hasta encontrar la columna que contiene el producto
                    while (elementoActual && elementoActual !== document.body) {
                        if (elementoActual.classList && (
                            elementoActual.classList.contains('col-4') ||
                            elementoActual.classList.contains('col-sm-6') ||
                            elementoActual.classList.contains('col-lg-4')
                        )) {
                            columnaProducto = elementoActual;
                            break;
                        }
                        elementoActual = elementoActual.parentElement;
                    }

                    // Si encontramos la columna, eliminarla con animación
                    if (columnaProducto) {
                        columnaProducto.style.transition = 'all 0.3s ease-out';
                        columnaProducto.style.opacity = '0';
                        columnaProducto.style.transform = 'scale(0.95)';

                        setTimeout(() => {
                            columnaProducto.remove(); // Eliminar del DOM después de la animación
                        }, 300);
                    }
                } else {
                    // Estamos en el catálogo normal, solo cambiar el botón a "no favorito"
                    formulario.setAttribute('action', urlAgregarFavorito);
                    // Cambiar estilo del botón a blanco (favorito inactivo)
                    botonEnviar.className = 'btn btn-outline-danger btn-sm shadow-sm';
                    botonEnviar.innerHTML = '<i class="far fa-heart"></i>';
                }
            }

            // Refrescar bloque de Más Favoritas si existe en la página
            refreshTopFavoritesSection();
        })
        .catch(error => {
            console.error('Error al actualizar favoritos:', error);
        });
});