<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Sneaker;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard
    public function index()
    {
        // Obtener estadísticas para el dashboard
        $totalSneakers = Sneaker::count();
        $totalBrands = Brand::count();
        $averagePrice = Sneaker::avg('price');
        $recentSneakers = Sneaker::with('brandModel')->latest()->take(5)->get();
        $recentSneakersCount = Sneaker::where('created_at', '>=', now()->subDays(7))->count();

        // Mostrar vista del dashboard con estadísticas
        return view('admin.dashboard', compact('totalSneakers', 'totalBrands', 'averagePrice', 'recentSneakers', 'recentSneakersCount'));
    }

    // Listado de zapatillas
    public function listSneakers()
    {
        // Obtener zapatillas con paginación y relación de marca
        $sneakers = Sneaker::with('brandModel')->paginate(15);

        // Mostrar vista con listado de zapatillas
        return view('admin.sneakers.index', compact('sneakers'));
    }

    // Formulario crear zapatillas
    public function createSneaker()
    {
        // Obtener marcas para el select del formulario
        $brands = Brand::all();
        $categories = ['hombre', 'mujer', 'niño', 'unisex'];

        // Mostrar el formulario de creación de zapatilla
        return view('admin.sneakers.create', compact('brands', 'categories'));
    }

    // Guardar zapatilla
    public function storeSneaker(Request $request)
    {
        // Validar datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:sneakers,sku',
            'brand_id' => 'required|exists:brands,id',
            'category' => 'required|in:hombre,mujer,niño,unisex',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required_without:image_file|nullable|url',
            'image_file' => 'required_without:image_url|nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'color' => 'nullable|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
        ], [
            'image_url.required_without' => 'Debes proporcionar una URL de imagen o cargar un archivo',
            'image_file.required_without' => 'Debes cargar un archivo de imagen o proporcionar una URL',
        ]);

        // Validación adicional para .avif
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = strtolower($file->getClientOriginalExtension());

            // Validar que sea un archivo de imagen
            $validExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif'];
            if (!in_array($extension, $validExtensions)) {
                return back()->withErrors(['image_file' => 'Tipo de archivo no válido'])->withInput();
            }

            // Procesar archivo de imagen
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('sneakers'), $filename);
            $validated['image_url'] = '/sneakers/' . $filename;
        }

        // Convertir sizes a array si viene como string CSV
        if ($validated['sizes']) {
            $validated['sizes'] = array_map('trim', explode(',', $validated['sizes']));
        }

        // Crear la zapatilla
        Sneaker::create($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.sneakers.index')
            ->with('success', 'Zapatilla creada exitosamente');
    }

    // Formulario editar zapatilla
    public function editSneaker($id)
    {
        // Obtener la zapatilla a editar
        $sneaker = Sneaker::findOrFail($id);
        $brands = Brand::all();

        // Categorías fijas para el formulario
        $categories = ['hombre', 'mujer', 'niño', 'unisex'];

        // Mostrar el formulario de edición con los datos de la zapatilla
        return view('admin.sneakers.edit', compact('sneaker', 'brands', 'categories'));
    }

    // Actualizar zapatilla
    public function updateSneaker(Request $request, $id)
    {
        // Obtener la zapatilla a actualizar
        $sneaker = Sneaker::findOrFail($id);

        // Validar datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:sneakers,sku,' . $id,
            'brand_id' => 'required|exists:brands,id',
            'category' => 'required|in:hombre,mujer,niño,unisex',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
            'color' => 'nullable|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Validación adicional para .avif
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = strtolower($file->getClientOriginalExtension());

            // Validar que sea un archivo de imagen
            $validExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif'];
            if (!in_array($extension, $validExtensions)) {
                return back()->withErrors(['image_file' => 'Tipo de archivo no válido'])->withInput();
            }

            // Eliminar imagen anterior si existe
            if ($sneaker->image_url && strpos($sneaker->image_url, '/sneakers/') !== false) {
                $oldFile = public_path($sneaker->image_url);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Procesar archivo de imagen
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('sneakers'), $filename);
            $validated['image_url'] = '/sneakers/' . $filename;
        } else if (!$request->filled('image_url')) {
            // Si no hay archivo ni URL nueva, mantener la imagen actual
            unset($validated['image_url']);
        }

        // Convertir sizes a array si viene como string CSV
        if ($validated['sizes']) {
            $validated['sizes'] = array_map('trim', explode(',', $validated['sizes']));
        }

        // Actualizar la zapatilla con los datos validados
        $sneaker->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.sneakers.index')
            ->with('success', 'Zapatilla actualizada exitosamente');
    }

    // Eliminar zapatilla
    public function destroySneaker($id)
    {
        // Obtener la zapatilla a eliminar
        $sneaker = Sneaker::findOrFail($id);
        $sneaker->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.sneakers.index')
            ->with('success', 'Zapatilla eliminada exitosamente');
    }

    // Gestionar marcas
    public function listBrands()
    {
        // Obtener marcas con conteo de zapatillas asociadas
        $brands = Brand::withCount('sneakers')->paginate(15);
        // Mostrar vista con marcas
        return view('admin.brands.index', compact('brands'));
    }

    public function createBrand()
    {
        // Mostrar formulario para crear marca
        return view('admin.brands.create');
    }

    public function storeBrand(Request $request)
    {
        // Validar datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|unique:brands,name',
            'description' => 'nullable|string',
            'logo_url' => 'required_without:logo_file|nullable|url',
            'logo_file' => 'required_without:logo_url|nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
        ], [
            'logo_url.required_without' => 'Debes proporcionar una URL de logo o cargar un archivo',
            'logo_file.required_without' => 'Debes cargar un archivo de logo o proporcionar una URL',
        ]);

        // Validación adicional para .avif
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $extension = strtolower($file->getClientOriginalExtension());

            // Validar que sea un archivo de imagen
            $validExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif'];
            if (!in_array($extension, $validExtensions)) {
                return back()->withErrors(['logo_file' => 'Tipo de archivo no válido'])->withInput();
            }

            // Procesar archivo de logo
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('brands'), $filename);
            $validated['logo_url'] = '/brands/' . $filename;
        }

        // Crear la marca
        Brand::create($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca creada exitosamente');
    }

    public function editBrand($id)
    {
        // Obtener la marca a editar
        $brand = Brand::findOrFail($id);

        // Mostrar el formulario de edición con los datos de la marca
        return view('admin.brands.edit', compact('brand'));
    }

    public function updateBrand(Request $request, $id)
    {
        // Obtener la marca a actualizar
        $brand = Brand::findOrFail($id);

        // Validar datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|unique:brands,name,' . $id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|url',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
        ]);

        // Procesar archivo de logo si existe
        if ($request->hasFile('logo_file')) {
            // Eliminar logo anterior si existe
            if ($brand->logo_url && strpos($brand->logo_url, '/brands/') !== false) {
                $oldFile = public_path($brand->logo_url);
                // Eliminar el archivo anterior si existe
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Procesar nuevo archivo de logo
            $file = $request->file('logo_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('brands'), $filename);
            $validated['logo_url'] = '/brands/' . $filename;

            // Si se sube un nuevo logo, ignorar cualquier URL proporcionada
        } else if (!$request->filled('logo_url')) {

            // Si no hay archivo ni URL nueva, mantener el logo actual
            unset($validated['logo_url']);
        }

        // Actualizar la marca con los datos validados
        $brand->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca actualizada exitosamente');
    }

    public function destroyBrand($id)
    {
        // Obtener la marca a eliminar
        $brand = Brand::findOrFail($id);
        $sneakersCount = $brand->sneakers()->count();

        // Eliminar todas las zapatillas asociadas a la marca
        $brand->sneakers()->delete();

        // Eliminar la marca
        $brand->delete();

        // Construir mensaje de éxito con conteo de zapatillas eliminadas
        $message = "Marca '{$brand->name}' y ";
        $message .= $sneakersCount > 0
            ? "{$sneakersCount} zapatillas asociadas eliminadas exitosamente"
            : "sus zapatillas asociadas eliminadas exitosamente";

        return redirect()->route('admin.brands.index')
            ->with('success', $message);
    }
}
