<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;
use Illuminate\Http\Request;

class SneakerController extends Controller
{
    /**
     * Mostrar el catálogo principal de zapatillas
     */
    public function index(Request $request)
    {
        $query = Sneaker::query();

        // BÚSQUEDA
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // FILTRO POR CATEGORÍA
        if ($request->filled('category')) {
            $query->byCategory($request->input('category'));
        }

        // FILTRO POR MARCA
        if ($request->filled('brand')) {
            $query->byBrand($request->input('brand'));
        }

        // FILTRO POR RANGO DE PRECIO
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $minPrice = max(0, (float) $request->input('min_price'));
            $maxPrice = max($minPrice, (float) $request->input('max_price'));
            $query->priceRange($minPrice, $maxPrice);
        }

        // FILTRO POR COLOR
        if ($request->filled('color')) {
            $query->byColor($request->input('color'));
        }

        // FILTRO POR TALLA
        if ($request->filled('size')) {
            $query->bySize($request->input('size'));
        }

        // Obtener los resultados con paginación
        $sneakers = $query->paginate(12);

        // Datos para los filtros
        $brands = Sneaker::getBrands();
        $colors = Sneaker::getColors();
        $sizes = Sneaker::getAvailableSizes();

        // Si es una solicitud AJAX o lazy load, retornar JSON con datos
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'html' => view('sneakers.partials.grid', compact('sneakers'))->render(),
                'hasMore' => $sneakers->hasMorePages(),
                'currentPage' => $sneakers->currentPage(),
            ]);
        }

        return view('sneakers.index', compact('sneakers', 'brands', 'colors', 'sizes'));
    }

    /**
     * Filtrar zapatillas por categoría
     */
    public function byCategory(Request $request, $category)
    {
        $request->merge(['category' => $category]);
        return $this->index($request);
    }

    /**
     * Mostrar todas las marcas disponibles
     */
    public function allBrands(Request $request)
    {
        $brands = Sneaker::getBrands();
        return view('sneakers.brands', compact('brands'));
    }

    /**
     * Mostrar zapatillas de una marca específica
     */
    public function byBrand(Request $request, $brand)
    {
        $brand = urldecode($brand);
        $request->merge(['brand' => $brand]);
        return $this->index($request);
    }

    /**
     * Buscar zapatillas
     */
    public function search(Request $request)
    {
        if (!$request->filled('q')) {
            if ($request->ajax()) {
                return response()->json(['html' => '', 'hasMore' => false, 'currentPage' => 1]);
            }
            return redirect()->route('catalogo');
        }

        $request->merge(['search' => $request->input('q')]);

        // Si es AJAX, devolver JSON
        if ($request->ajax()) {
            $query = Sneaker::query();
            $query->search($request->input('search'));
            $sneakers = $query->paginate(12);
            return response()->json([
                'html' => view('sneakers.partials.grid', compact('sneakers'))->render(),
                'hasMore' => $sneakers->hasMorePages(),
                'currentPage' => $sneakers->currentPage(),
            ]);
        }

        return $this->index($request);
    }

    /**
     * Mostrar detalles de una zapatilla (opcional)
     */
    public function show($id)
    {
        $sneaker = Sneaker::findOrFail($id);
        $relatedSneakers = Sneaker::where('brand', $sneaker->brand)
                                   ->where('id', '!=', $sneaker->id)
                                   ->limit(4)
                                   ->get();

        return view('sneakers.show', compact('sneaker', 'relatedSneakers'));
    }
}
