// Gestor del catálogo con carga diferida (lazy load)
class GestorCatalogo {
    constructor() {
        this.paginaActual = 1;              // Página actual de la paginación
        this.estaCargando = false;          // Evita peticiones simultáneas
        this.hayMasPaginas = true;          // Indica si el servidor tiene más productos
        this.urlBase = "/";                 // URL base del catálogo
        this.temporizadorBusqueda = null;   // Para el debounce del input de búsqueda
        this.iniciar();
    }

    iniciar() {
        this.configurarEventosFiltros();
        this.configurarCargaInfinita();
    }

    configurarEventosFiltros() {
        // Campo de búsqueda con debounce (espera 500ms tras dejar de escribir)
        let inputBusqueda = document.getElementById("searchInput");
        if (inputBusqueda) {
            inputBusqueda.addEventListener("input", (evento) => {
                clearTimeout(this.temporizadorBusqueda);
                this.temporizadorBusqueda = setTimeout(() => {
                    this.reiniciarYAplicarFiltros();
                }, 500);
            });
        }

        // Radio buttons de categoría
        let radiosCategoria = document.querySelectorAll('input[name="category"]');
        radiosCategoria.forEach(radio => {
            radio.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        });

        // Radio buttons de marca
        let radiosMarca = document.querySelectorAll('input[name="brand"]');
        radiosMarca.forEach(radio => {
            radio.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        });

        // Radio buttons de color
        let radiosColor = document.querySelectorAll('input[name="color"]');
        radiosColor.forEach(radio => {
            radio.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        });

        // Inputs de precio mínimo y máximo
        let inputPrecioMin = document.querySelector('input[name="min_price"]');
        let inputPrecioMax = document.querySelector('input[name="max_price"]');
        if (inputPrecioMin) {
            inputPrecioMin.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        }
        if (inputPrecioMax) {
            inputPrecioMax.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        }

        // Radio buttons de talla
        let radiosTalla = document.querySelectorAll('input[name="size"]');
        radiosTalla.forEach(radio => {
            radio.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        });
    }

    configurarCargaInfinita() {
        // Elemento centinela que al hacerse visible dispara la carga de más productos
        let centinela = document.getElementById("sentinel");
        if (!centinela) return;

        let observador = new IntersectionObserver((entradas) => {
            let entrada = entradas[0];
            // Si el centinela es visible Y hay más páginas Y no está cargando actualmente
            if (entrada.isIntersecting && this.hayMasPaginas && !this.estaCargando) {
                this.cargarSiguientePagina();
            }
        }, {
            rootMargin: "100px" // Dispara la carga 100px antes de que el centinela sea visible
        });

        observador.observe(centinela);
    }

    reiniciarYAplicarFiltros() {
        this.paginaActual = 1;           // Volver a la primera página
        this.hayMasPaginas = true;       // Asumir que hay más páginas con los nuevos filtros
        this.cargarProductos(true);      // true = reemplazar contenido existente
    }

    construirParametrosURL() {
        let parametros = new URLSearchParams();

        // Búsqueda por texto
        let inputBusqueda = document.getElementById("searchInput");
        if (inputBusqueda && inputBusqueda.value.trim() !== "") {
            parametros.append("search", inputBusqueda.value.trim());
        }

        // Categoría seleccionada
        let radioCategoria = document.querySelector('input[name="category"]:checked');
        if (radioCategoria && radioCategoria.value) {
            parametros.append("category", radioCategoria.value);
        }

        // Marca seleccionada
        let radioMarca = document.querySelector('input[name="brand"]:checked');
        if (radioMarca && radioMarca.value) {
            parametros.append("brand", radioMarca.value);
        }

        // Color seleccionado
        let radioColor = document.querySelector('input[name="color"]:checked');
        if (radioColor && radioColor.value) {
            parametros.append("color", radioColor.value);
        }

        // Precio mínimo
        let inputPrecioMin = document.querySelector('input[name="min_price"]');
        if (inputPrecioMin && inputPrecioMin.value) {
            parametros.append("min_price", inputPrecioMin.value);
        }

        // Precio máximo
        let inputPrecioMax = document.querySelector('input[name="max_price"]');
        if (inputPrecioMax && inputPrecioMax.value) {
            parametros.append("max_price", inputPrecioMax.value);
        }

        // Talla seleccionada
        let radioTalla = document.querySelector('input[name="size"]:checked');
        if (radioTalla && radioTalla.value) {
            parametros.append("size", radioTalla.value);
        }

        // Página actual
        parametros.append("page", this.paginaActual.toString());

        return parametros.toString();
    }

    cargarProductos(reemplazarContenido = false) {
        // Evitar peticiones duplicadas
        if (this.estaCargando) return;

        this.estaCargando = true;

        // Mostrar spinner de carga
        let spinner = document.getElementById("loadingSpinner");
        if (spinner) spinner.style.display = "flex";

        let parametros = this.construirParametrosURL();
        let url = `${this.urlBase}?${parametros}&ajax=1`;

        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        })
            .then(respuesta => respuesta.json())
            .then(datos => {
                let contenedorGrid = document.getElementById("sneakerGrid");

                if (reemplazarContenido) {
                    // Reemplazar todo el contenido (cuando se aplican filtros)
                    contenedorGrid.innerHTML = datos.html || "";
                } else {
                    // Añadir más productos al final (carga infinita)
                    if (datos.html) {
                        let divTemporal = document.createElement("div");
                        divTemporal.innerHTML = datos.html;
                        let nuevasTarjetas = divTemporal.querySelectorAll(".col-4, .col-sm-6, .col-lg-4");
                        nuevasTarjetas.forEach(tarjeta => {
                            contenedorGrid.appendChild(tarjeta);
                        });
                    }
                }

                // Actualizar si hay más páginas disponibles
                this.hayMasPaginas = datos.hasMore || false;

                // Ocultar spinner
                this.estaCargando = false;
                if (spinner) spinner.style.display = "none";
            })
            .catch(error => {
                console.error("Error al cargar productos:", error);
                this.estaCargando = false;
                if (spinner) spinner.style.display = "none";
            });
    }

    cargarSiguientePagina() {
        this.paginaActual++;                    // Incrementar página
        this.cargarProductos(false);            // false = añadir al final, no reemplazar
    }
}

// Iniciar cuando el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", () => {
    new GestorCatalogo();
});