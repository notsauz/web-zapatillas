@php
    $isFiltered = request()->filled('search') || request()->filled('category') || request()->filled('brand') || request()->filled('min_price') || request()->filled('max_price') || request()->filled('color') || request()->filled('size');
    $isCatalogRoot = request()->routeIs('catalogo') || request()->routeIs('catalogo.index');
@endphp

<div id="homeWidgets" class="mb-4" style="display: {{ $isCatalogRoot && !$isFiltered ? '' : 'none' }};">
    @include("sneakers.partials.top-favorites")
    @include("sneakers.partials.recently-viewed")
</div>
