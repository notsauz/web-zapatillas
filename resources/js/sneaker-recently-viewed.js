// Cargar zapatillas visitadas recientemente en la página de detalles
document.addEventListener("DOMContentLoaded", function () {
    // Contenedor donde se mostrarán las zapatillas recientes
    let contenedorRecientes = document.getElementById("recently-viewed-container");
    if (!contenedorRecientes) {
        return; // No existe el contenedor, salir
    }

    // Obtener la URL de la API desde el atributo data-url
    let urlAPI = contenedorRecientes.dataset.url;

    // Obtener los IDs de localStorage
    let viewedIds = JSON.parse(localStorage.getItem("viewed_sneakers") || "[]");

    // Si no hay IDs guardados, no mostrar nada
    if (viewedIds.length === 0) {
        return;
    }

    // Petición para obtener las zapatillas recientemente visitadas
    // Enviar los IDs en el header para que el servidor los procese
    fetch(urlAPI, {
        headers: {
            "X-Viewed-Sneakers": JSON.stringify(viewedIds)
        }
    })
        .then(respuesta => respuesta.json())
        .then(datos => {
            // Verificar si hay zapatillas para mostrar
            if (datos.sneakers && datos.sneakers.length > 0) {
                let zapatillasRecientes = datos.sneakers;
                let htmlGenerado = "";

                // Cabecera de la sección
                htmlGenerado += '<div class="recently-viewed-section mb-4">';
                htmlGenerado += '<h5 class="mb-3"><i class="fas fa-history me-2"></i>Últimas visitadas</h5>';
                htmlGenerado += '<div class="row g-2">';

                // Recorrer cada zapatilla y construir su tarjeta
                zapatillasRecientes.forEach(zapatilla => {
                    let urlImagen = zapatilla.image_url || "https://via.placeholder.com/100x80?text=No+Image";
                    let nombreZapatilla = zapatilla.name;
                    let precioFormateado = parseFloat(zapatilla.price).toFixed(2);
                    let urlZapatilla = zapatilla.url;

                    htmlGenerado += `
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="${urlZapatilla}" class="text-decoration-none">
                                <div class="recently-viewed-card p-2 border rounded shadow-sm h-100">
                                    <img src="${urlImagen}" 
                                        alt="${nombreZapatilla}" 
                                        class="img-fluid rounded" 
                                        style="height: 80px; object-fit: cover; width: 100%;">
                                    <div class="mt-2">
                                        <small class="text-dark d-block text-truncate">${nombreZapatilla}</small>
                                        <small class="text-success">$${precioFormateado}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                });

                // Cerrar contenedores
                htmlGenerado += "</div></div>";

                // Insertar el HTML generado en el contenedor
                contenedorRecientes.innerHTML = htmlGenerado;
            }
        })
        .catch(error => {
            console.error("Error al cargar zapatillas recientes:", error);
        });
});

// Función para guardar una zapatilla como visitada
// Esta función debe llamarse cuando se visita una página de detalles
function addToRecentlyViewed(sneakerId) {
    let viewedIds = JSON.parse(localStorage.getItem("viewed_sneakers") || "[]");
    
    // Eliminar si ya existe (para mover al inicio)
    viewedIds = viewedIds.filter(id => id != sneakerId);
    
    // Agregar al inicio
    viewedIds.unshift(sneakerId);
    
    // Mantener solo las últimas 5
    viewedIds = viewedIds.slice(0, 5);
    
    // Guardar en localStorage
    localStorage.setItem("viewed_sneakers", JSON.stringify(viewedIds));
}