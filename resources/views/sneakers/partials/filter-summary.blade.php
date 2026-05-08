@php
    $isFiltered = request()->filled('search') || request()->filled('category') || request()->filled('brand') || request()->filled('min_price') || request()->filled('max_price') || request()->filled('color') || request()->filled('size');
    $filterLabels = [];

    if (request('search')) {
        $filterLabels[] = __('Buscar') . ': "' . request('search') . '"';
    }
    if (request('category')) {
        $filterLabels[] = __('Categoría') . ': ' . __(ucfirst(request('category')));
    }
    if (request('brand')) {
        $filterLabels[] = __('Marca') . ': ' . request('brand');
    }
    if (request('color')) {
        $filterLabels[] = __('Color') . ': ' . \App\Models\Sneaker::translateLabel(request('color'));
    }
    if (request('size')) {
        $filterLabels[] = __('Talla') . ': ' . request('size');
    }
    if (request()->filled('min_price') || request()->filled('max_price')) {
        $range = '';
        if (request()->filled('min_price')) {
            $range = __('Desde') . ' ' . request('min_price');
        }
        if (request()->filled('max_price')) {
            $range .= $range ? ' ' . __('hasta') . ' ' . request('max_price') : __('Hasta') . ' ' . request('max_price');
        }
        $filterLabels[] = __('Precio') . ': ' . $range;
    }
@endphp

<div class="d-lg-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-3 mb-lg-0">{{ __('Catálogo de Zapatillas') }}</h2>
        <div id="filterSummaryContainer" class="mb-0 mt-2" style="{{ $isFiltered ? '' : 'display:none;' }}">
            <span id="filterSummaryLabel" class="text-muted">{{ __('Filtrado por') }}:</span>
            <div id="filterSummary" class="filter-summary">
                @foreach($filterLabels as $label)
                    <span class="filter-chip">
                        <span>{{ $label }}</span>
                        <button type="button" class="chip-close" aria-label="{{ __('Eliminar filtro') }}">&times;</button>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="catalogMeta" data-is-root="{{ request()->routeIs('catalogo') || request()->routeIs('catalogo.index') ? '1' : '0' }}"></div>
