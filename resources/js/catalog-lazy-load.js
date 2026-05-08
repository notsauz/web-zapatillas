// Gestor del catálogo con carga diferida (lazy load)
class GestorCatalogo {
    constructor() {
        this.paginaActual = this.parseQueryParam("page") || 1; // Página actual de la paginación
        this.estaCargando = false; // Evita peticiones simultáneas
        this.hayMasPaginas = true; // Indica si el servidor tiene más productos
        this.filtroForm = document.getElementById("filterForm");
        this.urlBase = this.filtroForm ? this.filtroForm.action : window.location.pathname || "/";
        this.temporizadorBusqueda = null; // Para el debounce del input de búsqueda
        this.iniciar();
        this.syncFormWithUrl();
        this.updateFilterSummaryDisplay();
        this.syncRedirectTargets(window.location.href);
    }

    iniciar() {
        this.configurarEventosFiltros();
        this.configurarCargaInfinita();
        window.addEventListener("popstate", () => {
            this.paginaActual = this.parseQueryParam("page") || 1;
            this.cargarProductos(true);
            this.updateFilterSummaryDisplay();
            this.syncRedirectTargets(window.location.href);
        });
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

        // Radio buttons de talla
        let radiosTalla = document.querySelectorAll('input[name="size"]');
        radiosTalla.forEach(radio => {
            radio.addEventListener("change", () => this.reiniciarYAplicarFiltros());
        });

        // Inputs de precio
        let inputMinPrecio = document.querySelector('input[name="min_price"]');
        if (inputMinPrecio) {
            inputMinPrecio.addEventListener("input", () => this.reiniciarYAplicarFiltros());
        }

        let inputMaxPrecio = document.querySelector('input[name="max_price"]');
        if (inputMaxPrecio) {
            inputMaxPrecio.addEventListener("input", () => this.reiniciarYAplicarFiltros());
        }

        // Sliders de precio
        let sliderMin = document.getElementById("minRange");
        if (sliderMin) {
            sliderMin.addEventListener("input", () => this.reiniciarYAplicarFiltros());
        }

        let sliderMax = document.getElementById("maxRange");
        if (sliderMax) {
            sliderMax.addEventListener("input", () => this.reiniciarYAplicarFiltros());
        }
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
        let parametros = this.construirParametrosURL();
        this.updateBrowserUrl(parametros);
        this.updateFilterSummaryDisplay();
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
        if (this.paginaActual > 1) {
            parametros.append("page", this.paginaActual.toString());
        }

        return parametros.toString();
    }

    getActiveFilters() {
        let filters = [];

        let inputBusqueda = document.getElementById("searchInput");
        if (inputBusqueda && inputBusqueda.value.trim() !== "") {
            filters.push({ key: "search", label: `Buscar: "${inputBusqueda.value.trim()}"` });
        }

        let radioCategoria = document.querySelector('input[name="category"]:checked');
        if (radioCategoria && radioCategoria.value) {
            filters.push({ key: "category", label: `Categoría: ${this.capitalizeText(radioCategoria.value)}` });
        }

        let radioMarca = document.querySelector('input[name="brand"]:checked');
        if (radioMarca && radioMarca.value) {
            filters.push({ key: "brand", label: `Marca: ${radioMarca.value}` });
        }

        let radioColor = document.querySelector('input[name="color"]:checked');
        if (radioColor && radioColor.value) {
            filters.push({ key: "color", label: `Color: ${radioColor.value}` });
        }

        let priceFilters = this.getPriceFilterValues();
        if (priceFilters.isActive) {
            if (priceFilters.minValue > 0) {
                filters.push({ key: "min_price", label: `Desde: ${priceFilters.minValue}` });
            }
            if (priceFilters.maxValue < priceFilters.maxPrice) {
                filters.push({ key: "max_price", label: `Hasta: ${priceFilters.maxValue}` });
            }
        }

        let radioTalla = document.querySelector('input[name="size"]:checked');
        if (radioTalla && radioTalla.value) {
            filters.push({ key: "size", label: `Talla: ${radioTalla.value}` });
        }

        return filters;
    }

    updateFilterSummaryDisplay() {
        let summaryContainer = document.getElementById("filterSummaryContainer");
        let summaryEl = document.getElementById("filterSummary");
        let labelEl = document.getElementById("filterSummaryLabel");
        let homeWidgets = document.getElementById("homeWidgets");
        let filters = this.getActiveFilters();

        if (summaryContainer && summaryEl && labelEl) {
            summaryEl.innerHTML = "";

            if (filters.length > 0) {
                summaryContainer.style.display = "";
                labelEl.style.display = "inline";
                filters.forEach(filter => summaryEl.appendChild(this.createFilterChip(filter)));
            } else {
                summaryContainer.style.display = "none";
            }
        }

        this.updateFilterSectionBadges();

        if (homeWidgets) {
            homeWidgets.style.display = this.isCatalogRoot() && filters.length === 0 ? '' : 'none';
        }
    }

    updateFilterSectionBadges() {
        let hasActiveFilters = this.getActiveFilters().length > 0;
        let priceFilters = this.getPriceFilterValues();
        let badgeMap = {
            filters: hasActiveFilters ? 'active' : null,
            category: document.querySelector('input[name="category"]:checked')?.value,
            brand: document.querySelector('input[name="brand"]:checked')?.value,
            color: document.querySelector('input[name="color"]:checked')?.value,
            size: document.querySelector('input[name="size"]:checked')?.value,
            price: priceFilters.isActive ? 'active' : null,
        };

        document.querySelectorAll('.filter-badge').forEach(badge => {
            let section = badge.dataset.section;
            if (!section) return;
            let isActive = badgeMap[section] && badgeMap[section] !== '';
            badge.style.display = isActive ? 'inline' : 'none';
        });
    }

    syncInputsWithSlider() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");

        if (!minRange || !maxRange || !minInput || !maxInput) {
            return;
        }

        let minValue = parseInt(minRange.value, 10);
        let maxValue = parseInt(maxRange.value, 10);
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || parseInt(maxRange.max, 10);

        if (minValue > maxValue) {
            minValue = maxValue;
            minRange.value = minValue;
        }
        if (maxValue < minValue) {
            maxValue = minValue;
            maxRange.value = maxValue;
        }

        minInput.value = minValue;
        maxInput.value = maxValue;
        minRange.setAttribute('max', maxValue);
        maxRange.setAttribute('min', minValue);
        document.getElementById("minPriceLabel").textContent = minValue;
        document.getElementById("maxPriceLabel").textContent = maxValue;
    }

    handleMinSliderInput() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || 0;

        if (!minRange || !maxRange || !minInput || !maxInput) {
            return;
        }

        let minValue = Math.max(0, Math.min(parseInt(minRange.value, 10), maxPrice));
        let maxValue = Math.max(0, Math.min(parseInt(maxRange.value, 10), maxPrice));

        if (minValue >= maxValue) {
            minValue = maxValue;
            minRange.value = minValue;
        }

        minRange.setAttribute('max', maxValue);
        maxRange.setAttribute('min', minValue);
        minInput.value = minValue;
        maxInput.value = maxValue;
        document.getElementById("minPriceLabel").textContent = minValue;
        document.getElementById("maxPriceLabel").textContent = maxValue;
    }

    handleMaxSliderInput() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || 0;

        if (!minRange || !maxRange || !minInput || !maxInput) {
            return;
        }

        let minValue = Math.max(0, Math.min(parseInt(minRange.value, 10), maxPrice));
        let maxValue = Math.max(0, Math.min(parseInt(maxRange.value, 10), maxPrice));

        if (maxValue <= minValue) {
            maxValue = minValue;
            maxRange.value = maxValue;
        }

        minRange.setAttribute('max', maxValue);
        maxRange.setAttribute('min', minValue);
        minInput.value = minValue;
        maxInput.value = maxValue;
        document.getElementById("minPriceLabel").textContent = minValue;
        document.getElementById("maxPriceLabel").textContent = maxValue;
    }

    syncSliderWithInputs() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");

        if (!minRange || !maxRange || !minInput || !maxInput) {
            return;
        }

        let minValue = parseInt(minInput.value, 10);
        let maxValue = parseInt(maxInput.value, 10);
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || parseInt(maxRange.max, 10);

        if (Number.isNaN(minValue) || minValue < 0) {
            minValue = 0;
        }
        if (Number.isNaN(maxValue) || maxValue < 0) {
            maxValue = maxPrice;
        }

        if (minValue > maxValue) {
            minValue = maxValue;
        }
        if (maxValue < minValue) {
            maxValue = minValue;
        }

        minValue = Math.max(0, Math.min(minValue, maxPrice));
        maxValue = Math.max(0, Math.min(maxValue, maxPrice));

        minInput.value = minValue;
        maxInput.value = maxValue;
        minRange.value = minValue;
        maxRange.value = maxValue;
        minRange.max = maxValue;
        maxRange.min = minValue;
        document.getElementById("minPriceLabel").textContent = minValue;
        document.getElementById("maxPriceLabel").textContent = maxValue;
    }

    normalizePriceSlider() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");

        if (!minRange || !maxRange || !minInput || !maxInput) {
            return;
        }

        let minValue = parseInt(minRange.value, 10);
        let maxValue = parseInt(maxRange.value, 10);
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || parseInt(maxRange.max, 10);

        if (minValue > maxValue) {
            minValue = maxValue;
            minRange.value = minValue;
        }
        if (maxValue < minValue) {
            maxValue = minValue;
            maxRange.value = maxValue;
        }

        minValue = Math.max(0, Math.min(minValue, maxPrice));
        maxValue = Math.max(0, Math.min(maxValue, maxPrice));

        minRange.value = minValue;
        maxRange.value = maxValue;
        minRange.setAttribute('max', maxValue);
        maxRange.setAttribute('min', minValue);
        minInput.value = minValue;
        maxInput.value = maxValue;
        document.getElementById("minPriceLabel").textContent = minValue;
        document.getElementById("maxPriceLabel").textContent = maxValue;
    }

    getPriceFilterValues() {
        let minInput = document.getElementById("minPriceInput");
        let maxInput = document.getElementById("maxPriceInput");
        let defaultMax = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || 0;

        if (!minInput || !maxInput) {
            return { isActive: false, minValue: 0, maxValue: defaultMax, maxPrice: defaultMax };
        }

        let minValue = parseInt(minInput.value, 10);
        let maxValue = parseInt(maxInput.value, 10);
        if (Number.isNaN(minValue)) minValue = 0;
        if (Number.isNaN(maxValue)) maxValue = defaultMax;

        minValue = Math.max(0, Math.min(minValue, defaultMax));
        maxValue = Math.max(0, Math.min(maxValue, defaultMax));
        if (minValue > maxValue) {
            minValue = maxValue;
        }

        let isActive = minValue > 0 || maxValue < defaultMax;
        return { isActive, minValue, maxValue, maxPrice: defaultMax };
    }

    updatePriceRangeUI() {
        let minRange = document.getElementById("minPriceRange");
        let maxRange = document.getElementById("maxPriceRange");
        let rangeHighlight = document.getElementById("priceSliderRange");
        let maxPrice = parseInt(document.querySelector('.price-slider')?.dataset.maxPrice, 10) || 0;

        if (!minRange || !maxRange || !rangeHighlight || maxPrice === 0) {
            return;
        }

        let minValue = Math.min(parseInt(minRange.value, 10), maxPrice);
        let maxValue = Math.min(parseInt(maxRange.value, 10), maxPrice);

        let minPercent = (minValue / maxPrice) * 100;
        let maxPercent = (maxValue / maxPrice) * 100;

        rangeHighlight.style.left = `${minPercent}%`;
        rangeHighlight.style.width = `${Math.max(maxPercent - minPercent, 0)}%`;
    }

    createFilterChip(filter) {
        let chip = document.createElement("span");
        chip.className = "filter-chip";

        let labelSpan = document.createElement("span");
        labelSpan.textContent = filter.label;

        let closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.className = "chip-close";
        closeButton.setAttribute("aria-label", `Eliminar filtro ${filter.label}`);
        closeButton.innerHTML = "&times;";
        closeButton.addEventListener("click", (event) => {
            event.stopPropagation();
            this.clearFilter(filter.key);
            this.reiniciarYAplicarFiltros();
        });

        chip.append(labelSpan, closeButton);
        return chip;
    }

    clearFilter(key) {
        switch (key) {
            case "search": {
                let inputBusqueda = document.getElementById("searchInput");
                if (inputBusqueda) inputBusqueda.value = "";
                break;
            }
            case "category": {
                let catAll = document.getElementById("cat_all");
                if (catAll) catAll.checked = true;
                break;
            }
            case "brand": {
                let brandAll = document.getElementById("brand_all");
                if (brandAll) brandAll.checked = true;
                break;
            }
            case "color": {
                let colorAll = document.getElementById("color_all");
                if (colorAll) colorAll.checked = true;
                break;
            }
            case "size": {
                let sizeAll = document.getElementById("size_all");
                if (sizeAll) sizeAll.checked = true;
                break;
            }
            case "min_price": {
                let inputPrecioMin = document.querySelector('input[name="min_price"]');
                if (inputPrecioMin) inputPrecioMin.value = "";
                break;
            }
            case "max_price": {
                let inputPrecioMax = document.querySelector('input[name="max_price"]');
                if (inputPrecioMax) inputPrecioMax.value = "";
                break;
            }
        }
    }

    capitalizeText(value) {
        if (!value) {
            return value;
        }
        return value.charAt(0).toUpperCase() + value.slice(1);
    }

    isCatalogRoot() {
        let path = window.location.pathname.replace(/\/+$/, "");
        return path === "" || path === "/" || path === "/catalogo";
    }

    parseQueryParam(name) {
        let params = new URLSearchParams(window.location.search);
        let value = params.get(name);
        if (!value) {
            return null;
        }
        let parsed = parseInt(value, 10);
        return Number.isNaN(parsed) ? null : parsed;
    }

    normalizeRedirectUrl(url) {
        try {
            let parsedUrl = new URL(url, window.location.origin);
            parsedUrl.searchParams.delete("ajax");
            parsedUrl.searchParams.delete("page");
            return parsedUrl.pathname + (parsedUrl.search ? `?${parsedUrl.searchParams.toString()}` : "");
        } catch (error) {
            return url;
        }
    }

    syncRedirectTargets(currentUrl) {
        let normalizedUrl = this.normalizeRedirectUrl(currentUrl);

        document.querySelectorAll('input[name="return_to"]').forEach(input => {
            input.value = normalizedUrl;
        });

        document.querySelectorAll('a.login-redirect').forEach(link => {
            let hrefUrl = new URL(link.href, window.location.origin);
            hrefUrl.searchParams.set("redirect_to", normalizedUrl);
            link.href = hrefUrl.toString();
        });

        document.querySelectorAll('a.register-redirect').forEach(link => {
            let hrefUrl = new URL(link.href, window.location.origin);
            hrefUrl.searchParams.set("redirect_to", normalizedUrl);
            link.href = hrefUrl.toString();
        });
    }

    syncFormWithUrl() {
        let params = new URLSearchParams(window.location.search);

        // Sincronizar búsqueda
        let searchValue = params.get("search");
        if (searchValue) {
            let searchInput = document.getElementById("searchInput");
            if (searchInput) searchInput.value = searchValue;
        }

        // Sincronizar categoría
        let categoryValue = params.get("category");
        if (categoryValue) {
            let categoryRadio = document.querySelector(`input[name="category"][value="${categoryValue}"]`);
            if (categoryRadio) categoryRadio.checked = true;
        }

        // Sincronizar marca
        let brandValue = params.get("brand");
        if (brandValue) {
            let brandRadio = document.querySelector(`input[name="brand"][value="${brandValue}"]`);
            if (brandRadio) brandRadio.checked = true;
        }

        // Sincronizar color
        let colorValue = params.get("color");
        if (colorValue) {
            let colorRadio = document.querySelector(`input[name="color"][value="${colorValue}"]`);
            if (colorRadio) colorRadio.checked = true;
        }

        // Sincronizar precio mínimo
        let minPriceValue = params.get("min_price");
        if (minPriceValue) {
            let minPriceInput = document.querySelector('input[name="min_price"]');
            if (minPriceInput) minPriceInput.value = minPriceValue;
        }

        // Sincronizar precio máximo
        let maxPriceValue = params.get("max_price");
        if (maxPriceValue) {
            let maxPriceInput = document.querySelector('input[name="max_price"]');
            if (maxPriceInput) maxPriceInput.value = maxPriceInput.value = maxPriceValue;
        }

        // Sincronizar talla
        let sizeValue = params.get("size");
        if (sizeValue) {
            let sizeRadio = document.querySelector(`input[name="size"][value="${sizeValue}"]`);
            if (sizeRadio) sizeRadio.checked = true;
        }

        // Sincronizar sliders de precio si hay valores
        if (minPriceValue || maxPriceValue) {
            this.syncSliderWithInputs();
            this.updatePriceRangeUI();
        }
    }

    hasActiveFiltersInUrl() {
        let params = new URLSearchParams(window.location.search);
        return params.has("search") || params.has("category") || params.has("brand") || 
               params.has("color") || params.has("min_price") || params.has("max_price") || 
               params.has("size");
    }

    updateBrowserUrl(parametros) {
        let url = this.urlBase;
        if (parametros) {
            url += `?${parametros}`;
        }
        history.replaceState(null, "", url);
        this.syncRedirectTargets(url);
    }

    cargarProductos(reemplazarContenido = false) {
        // Evitar peticiones duplicadas
        if (this.estaCargando) return;

        this.estaCargando = true;

        // Mostrar spinner de carga
        let spinner = document.getElementById("loadingSpinner");
        if (spinner) spinner.style.display = "flex";

        let parametros = this.construirParametrosURL();
        let url = this.urlBase;
        if (parametros) {
            url += `?${parametros}&ajax=1`;
        } else {
            url += "?ajax=1";
        }

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

                this.updateFilterSummaryDisplay();
                this.syncRedirectTargets(window.location.href);
            })
            .catch(error => {
                console.error("Error al cargar productos:", error);
                this.estaCargando = false;
                if (spinner) spinner.style.display = "none";
            });
    }

    cargarSiguientePagina() {
        this.paginaActual++;                    // Incrementar página
        let parametros = this.construirParametrosURL();
        this.updateBrowserUrl(parametros);
        this.cargarProductos(false);            // false = añadir al final, no reemplazar
    }
}

// Iniciar cuando el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", () => {
    new GestorCatalogo();
});