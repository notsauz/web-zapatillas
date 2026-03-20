<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Zapatilla;
use Illuminate\Http\Request;

/**
 * Controlador Zapatilla
 *
 * Maneja CRUD completo para la entidad Zapatilla.
 */
class ZapatillaController extends Controller
{
    // Listado de zapatillas con filtros y paginación
    public function index(Request $request)
    {
        $zapatillas = Zapatilla::with('modelo.marca')->orderBy('id', 'desc')->paginate(10);
        $marcas = Marca::orderBy('nombre')->get();
        $modelos = Modelo::orderBy('nombre')->get();

        return view('zapatillas.index', compact('zapatillas', 'marcas', 'modelos'));
    }

    // Formulario para crear nueva zapatilla
    public function create()
    {
        $marcas = Marca::orderBy('nombre')->get();
        $modelos = Modelo::orderBy('nombre')->get();

        return view('zapatillas.create', compact('marcas', 'modelos'));
    }

    // Almacenar nueva zapatilla con validación
    public function store(Request $request)
    {
        // Validación de datos
        $data = $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'sku' => 'required|string|max:255|unique:zapatillas,sku',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url',
            'tendencia' => 'sometimes|boolean',
        ]);

        // Asegurar que el campo tendencia se guarde como booleano
        $data['tendencia'] = $request->has('tendencia');

        // Crear la zapatilla
        Zapatilla::create($data);

        // Redireccionar con mensaje de éxito
        return redirect()->route('zapatillas.index')->with('success', 'Zapatilla creada correctamente.');
    }

    // Mostrar detalles de una zapatilla
    public function show(Zapatilla $zapatilla)
    {
        $zapatilla->load('modelo.marca');

        return view('zapatillas.show', compact('zapatilla'));
    }

    // Editar zapatilla con validación
    public function edit(Zapatilla $zapatilla)
    {
        $marcas = Marca::orderBy('nombre')->get();
        $modelos = Modelo::orderBy('nombre')->get();

        return view('zapatillas.edit', compact('zapatilla', 'marcas', 'modelos'));
    }

    // Actualizar zapatilla con validación
    public function update(Request $request, Zapatilla $zapatilla)
    {
        $data = $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'sku' => 'required|string|max:255|unique:zapatillas,sku,' . $zapatilla->id,
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url',
            'tendencia' => 'sometimes|boolean',
        ]);

        $data['tendencia'] = $request->has('tendencia');

        $zapatilla->update($data);

        return redirect()->route('zapatillas.index')->with('success', 'Zapatilla actualizada correctamente.');
    }

    // Eliminar zapatilla
    public function destroy(Zapatilla $zapatilla)
    {
        $zapatilla->delete();

        return redirect()->route('zapatillas.index')->with('success', 'Zapatilla eliminada correctamente.');
    }
}
