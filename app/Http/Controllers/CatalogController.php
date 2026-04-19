<?php

namespace App\Http\Controllers;

use App\Models\Zapatilla;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Zapatilla::query();

        // Filtro por búsqueda
        if ($request->search) {
            $query->search($request->search);
        }

        // Filtro por categoría
        if ($request->categoria) {
            $query->byCategoria($request->categoria);
        }

        // Filtro por rango de precio
        if ($request->min_price || $request->max_price) {
            $minPrice = $request->min_price ?? 0;
            $maxPrice = $request->max_price ?? 999999;
            $query->byPrice($minPrice, $maxPrice);
        }

        // Filtro por color
        if ($request->color) {
            $query->byColor($request->color);
        }

        // Filtro por talla
        if ($request->talla) {
            $query->bySize($request->talla);
        }

        $zapatillas = $query->paginate(12);

        $categorias = ['hombre', 'mujer', 'niño', 'unisex'];
        $colores = Zapatilla::distinct('color')->whereNotNull('color')->pluck('color');
        $marcas = Zapatilla::distinct('marca')->whereNotNull('marca')->pluck('marca');

        return view('catalog.index', compact('zapatillas', 'categorias', 'colores', 'marcas'));
    }

    public function show(Zapatilla $zapatilla)
    {
        return view('catalog.show', compact('zapatilla'));
    }

    public function byCategory($categoria, Request $request)
    {
        $request->merge(['categoria' => $categoria]);
        return $this->index($request);
    }

    public function brands(Request $request)
    {
        $request->merge(['most_brands' => true]);
        return $this->index($request);
    }
}
