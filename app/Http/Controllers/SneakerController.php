<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;
use Illuminate\Http\Request;

class SneakerController extends Controller
{
    // Mostrar el catálogo de zapatillas con soporte para búsqueda, filtros por categoría, marca, precio, color y talla, además de paginación y carga dinámica con AJAX
    public function index(Request $peticion)
    {
        $consulta = Sneaker::query();

        // BÚSQUEDA
        if ($peticion->filled("search")) {
            $consulta->search($peticion->input("search"));
        }

        // FILTRO POR CATEGORÍA
        if ($peticion->filled("category")) {
            $consulta->byCategory($peticion->input("category"));
        }

        // FILTRO POR MARCA
        if ($peticion->filled("brand")) {
            $consulta->byBrand($peticion->input("brand"));
        }

        // FILTRO POR RANGO DE PRECIO
        if ($peticion->filled("min_price") || $peticion->filled("max_price")) {
            $precioMin = $peticion->filled("min_price") ? max(0, (float) $peticion->input("min_price")) : null;
            $precioMax = $peticion->filled("max_price") ? max(0, (float) $peticion->input("max_price")) : null;
            $consulta->priceRange($precioMin, $precioMax);
        }

        // FILTRO POR COLOR
        if ($peticion->filled("color")) {
            $consulta->byColor($peticion->input("color"));
        }

        // FILTRO POR TALLA
        if ($peticion->filled("size")) {
            $consulta->bySize($peticion->input("size"));
        }

        // Obtener los resultados con paginación
        $zapatillas = $consulta->paginate(12);

        // Obtener IDs de favoritos si el usuario está autenticado
        $idsFavoritos = auth()->check()
            ? auth()->user()->favoriteSneakers()->pluck("sneakers.id")->toArray()
            : [];

        // Datos para los filtros
        $marcas = Sneaker::getBrands();
        $colores = Sneaker::getColors();
        $tallas = Sneaker::getAvailableSizes();

        // Si es una solicitud AJAX o lazy load, retornar JSON con datos
        if ($peticion->ajax() || $peticion->get("ajax")) {
            return response()->json([
                "html" => view("sneakers.partials.grid", compact("zapatillas", "idsFavoritos"))->render(),
                "hasMore" => $zapatillas->hasMorePages(),
                "currentPage" => $zapatillas->currentPage(),
            ]);
        }

        return view("sneakers.index", compact("zapatillas", "marcas", "colores", "tallas", "idsFavoritos"));
    }

    // Mostrar zapatillas filtradas por categoría
    public function byCategory(Request $peticion, $categoria)
    {
        $peticion->merge(["category" => $categoria]);
        return $this->index($peticion);
    }

    // Mostrar todas las marcas disponibles para el filtro
    public function allBrands(Request $peticion)
    {
        $marcas = Sneaker::getBrands();
        return view("sneakers.brands", compact("marcas"));
    }

    // Filtrar zapatillas por marca
    public function byBrand(Request $peticion, $marca)
    {
        $marca = urldecode($marca);
        $peticion->merge(["brand" => $marca]);
        return $this->index($peticion);
    }

    // Mostrar detalles de una zapatilla específica con productos relacionados y estado de favorito
    public function show($id)
    {
        $zapatilla = Sneaker::findOrFail($id);
        $relacionadas = Sneaker::where("brand", $zapatilla->brand)
            ->where("id", "!=", $zapatilla->id)
            ->limit(4)
            ->get();

        $esFavorito = false;
        if (auth()->check()) {
            $esFavorito = auth()->user()->favoriteSneakers()->where("sneaker_id", $zapatilla->id)->exists();
        }

        return view("sneakers.show", compact("zapatilla", "relacionadas", "esFavorito"));
    }
}