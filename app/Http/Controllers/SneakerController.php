<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SneakerController extends Controller
{
    // Nombre de la cookie para almacenar zapatillas visitadas recientemente
    private const VIEWED_SNEAKERS_COOKIE = "viewed_sneakers";
    // Máximo de zapatillas a guardar en el historial
    private const MAX_VIEWED_SNEAKERS = 5;
    // Duración de la cookie: 30 días
    private const COOKIE_DURATION = 86400 * 30;

    // Obtener las últimas zapatillas visitadas desde la cookie
    public function getViewedSneakers()
    {
        $viewedIds = json_decode(Cookie::get(self::VIEWED_SNEAKERS_COOKIE, "[]"), true);

        if (empty($viewedIds)) {
            return collect([]);
        }

        return Sneaker::whereIn("id", $viewedIds)->get()->map(function ($sneaker) use ($viewedIds) {
            $sneaker->viewed_at = array_search($sneaker->id, $viewedIds);
            return $sneaker;
        })->sortBy("viewed_at")->values();
    }

    // API: Obtener zapatillas visitadas recientemente en formato JSON
    public function getRecentlyViewed()
    {
        $sneakers = $this->getViewedSneakers();

        return response()->json([
            "sneakers" => $sneakers->map(function ($sneaker) {
                return [
                    "id" => $sneaker->id,
                    "name" => $sneaker->name,
                    "price" => $sneaker->price,
                    "image_url" => $sneaker->image_url,
                    "url" => route("sneaker.show", $sneaker->id)
                ];
            })
        ]);
    }

    // Agregar una zapatilla al historial de visitadas
    private function addToViewedSneakers($sneakerId)
    {
        $viewedIds = json_decode(Cookie::get(self::VIEWED_SNEAKERS_COOKIE, "[]"), true);

        // Eliminar si ya existe (para mover al inicio)
        $viewedIds = array_filter($viewedIds, function ($id) use ($sneakerId) {
            return $id != $sneakerId;
        });

        // Agregar al inicio
        array_unshift($viewedIds, $sneakerId);

        // Mantener solo las últimas MAX_VIEWED_SNEAKERS
        $viewedIds = array_slice($viewedIds, 0, self::MAX_VIEWED_SNEAKERS);

        Cookie::queue(
            self::VIEWED_SNEAKERS_COOKIE,
            json_encode($viewedIds),
            self::COOKIE_DURATION
        );
    }

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

        // Obtener zapatillas vistas recientemente
        $vistasRecently = $this->getViewedSneakers();

        // Datos para los filtros
        $marcas = Sneaker::getBrands();
        $colores = Sneaker::getColors();
        $tallas = Sneaker::getAvailableSizes();

        // Si es una solicitud AJAX o lazy load, retornar JSON con datos
        if ($peticion->ajax() || $peticion->get("ajax")) {
            return response()->json([
                "html" => view("sneakers.partials.grid", ["sneakers" => $zapatillas, "favoriteSneakerIds" => $idsFavoritos])->render(),
                "hasMore" => $zapatillas->hasMorePages(),
                "currentPage" => $zapatillas->currentPage(),
            ]);
        }

        return view("sneakers.index", compact("zapatillas", "marcas", "colores", "tallas", "idsFavoritos", "vistasRecently"));
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
        $sneaker = Sneaker::findOrFail($id);

        // Agregar a las zapatillas visitadas recientemente (cookie)
        $this->addToViewedSneakers($sneaker->id);

        $relacionadas = Sneaker::where("brand", $sneaker->brand)
            ->where("id", "!=", $sneaker->id)
            ->limit(4)
            ->get();

        $esFavorito = false;
        if (auth()->check()) {
            $esFavorito = auth()->user()->favoriteSneakers()->where("sneaker_id", $sneaker->id)->exists();
        }

        // Obtener zapatillas vistas recientemente
        $vistasRecently = $this->getViewedSneakers();

        return view("sneakers.show", compact("sneaker", "relacionadas", "esFavorito", "vistasRecently"));
    }
}