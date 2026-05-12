<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Sneaker;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Extensiones de imagen permitidas para subir archivos
    private const EXTENSIONES_VALIDAS = ["jpeg", "jpg", "png", "gif", "webp", "avif"];

    // Categorías disponibles para las zapatillas
    private const CATEGORIAS = ["hombre", "mujer", "niño", "unisex"];

    // Dashboard del panel de administración con estadísticas generales y últimas zapatillas añadidas
    public function index()
    {
        // Obtener estadísticas generales del sistema
        $totalZapatillas = Sneaker::count();
        $totalMarcas = Brand::count();
        $precioPromedio = Sneaker::avg("price");

        // Últimas 5 zapatillas añadidas con su información de marca
        $zapatillasRecientes = Sneaker::with("brandModel")->latest()->take(5)->get();

        // Zapatillas añadidas en los últimos 7 días
        $zapatillasUltimaSemana = Sneaker::where("created_at", ">=", now()->subDays(7))->count();

        return view("admin.dashboard", compact(
            "totalZapatillas",
            "totalMarcas",
            "precioPromedio",
            "zapatillasRecientes",
            "zapatillasUltimaSemana"
        ));
    }

    // ZAPATILLAS

    // Lista todas las zapatillas en el panel de administración con paginación y su información de marca para mostrar el nombre de la marca
    public function listSneakers()
    {
        // Cargar zapatillas con su relación de marca para mostrar el nombre de la marca
        $zapatillas = Sneaker::with("brandModel")->paginate(15);
        return view("admin.sneakers.index", compact("zapatillas"));
    }

    // Muestra el formulario para crear una nueva zapatilla y cargar la vista correspondiente con el formulario de creación de zapatilla, el selector de marcas y categorías
    public function createSneaker()
    {
        // Obtener todas las marcas para mostrarlas en un <select>
        $marcas = Brand::all();
        return view("admin.sneakers.create", [
            "brands" => $marcas,           // Mantener nombre original para la vista
            "categories" => self::CATEGORIAS
        ]);
    }

    // Guarda una nueva zapatilla en la base de datos, valida los datos y procesa la imagen si se subió un archivo
    public function storeSneaker(Request $peticion)
    {
        // Validar todos los campos requeridos
        $datos = $this->validarZapatilla($peticion);

        // Si se subió un archivo de imagen, guardarlo y actualizar la URL
        $datos = $this->procesarImagen($peticion, $datos, "image_file", "image_url", "sneakers");

        // Convertir tallas de string "38,39,40" a array ["38","39","40"]
        $datos = $this->procesarTallas($datos);

        // Crear la zapatilla en la base de datos
        Sneaker::create($datos);

        return redirect()->route("admin.sneakers.index")
            ->with("success", "Zapatilla creada exitosamente");
    }

    // Muestra el formulario de edición con los datos actuales de la zapatilla y su imagen 
    public function editSneaker($id)
    {
        // Buscar la zapatilla o devolver 404 si no existe
        $zapatilla = Sneaker::findOrFail($id);
        $marcas = Brand::all();

        return view("admin.sneakers.edit", [
            "sneaker" => $zapatilla,
            "brands" => $marcas,
            "categories" => self::CATEGORIAS
        ]);
    }

    // Actualiza los datos de una zapatilla existente, maneja la actualización de la imagen si se sube un nuevo archivo o se cambia la URL, eliminando la imagen anterior si corresponde
    public function updateSneaker(Request $peticion, $id)
    {
        // Buscar la zapatilla o devolver 404 si no existe
        $zapatilla = Sneaker::findOrFail($id);

        // Validar datos (el SKU permite que sea el mismo si no se modifica)
        $datos = $this->validarZapatilla($peticion, $id);

        // Procesar nueva imagen y eliminar la anterior si corresponde
        $datos = $this->procesarImagen($peticion, $datos, "image_file", "image_url", "sneakers", $zapatilla->image_url);

        // Convertir tallas de string a array
        $datos = $this->procesarTallas($datos);

        // Actualizar la zapatilla con los nuevos datos
        $zapatilla->update($datos);

        return redirect()->route("admin.sneakers.index")
            ->with("success", "Zapatilla actualizada exitosamente");
    }

    // Elimina una zapatilla y su imagen asociada si fue subida al servidor para mantener el almacenamiento limpio y evitar archivos huérfanos
    public function destroySneaker($id)
    {
        // Buscar y eliminar la zapatilla
        Sneaker::findOrFail($id)->delete();
        return redirect()->route("admin.sneakers.index")
            ->with("success", "Zapatilla eliminada exitosamente");
    }

    // MARCAS

    // Lista todas las marcas en el panel de administración con el número de zapatillas que tiene cada una
    public function listBrands()
    {
        // Obtener marcas con el número de zapatillas que tiene cada una
        $marcas = Brand::withCount("sneakers")->paginate(15);
        return view("admin.brands.index", compact("marcas"));
    }

    // Muestra el formulario para crear una nueva marca y cargar la vista correspondiente con el formulario de creación de marca y el selector de categorías si es necesario para la marca (para futuras funcionalidades)
    public function createBrand()
    {
        return view("admin.brands.create");
    }

    // Guarda una nueva marca en la base de datos, valida los datos y procesa el logo si se subió un archivo
    public function storeBrand(Request $peticion)
    {
        // Validar los datos de la marca
        $datos = $this->validarMarca($peticion);

        // Si se subió un archivo de logo, guardarlo y actualizar la URL
        $datos = $this->procesarImagen($peticion, $datos, "logo_file", "logo_url", "brands");

        // Crear la marca en la base de datos
        Brand::create($datos);

        return redirect()->route("admin.brands.index")
            ->with("success", "Marca creada exitosamente");
    }

    // Muestra el formulario de edición con los datos actuales de la marca y su logo
    public function editBrand($id)
    {
        // Buscar la marca o devolver 404 si no existe
        $marca = Brand::findOrFail($id);
        return view("admin.brands.edit", compact("marca"));
    }

    // Actualiza los datos de una marca existente y maneja la actualización del logo si se sube un nuevo archivo o se cambia la URL, eliminando el logo anterior si corresponde
    public function updateBrand(Request $peticion, $id)
    {
        // Buscar la marca o devolver 404 si no existe
        $marca = Brand::findOrFail($id);

        // Validar datos (el nombre permite que sea el mismo si no se modifica)
        $datos = $this->validarMarca($peticion, $id);

        // Procesar nuevo logo y eliminar el anterior si corresponde
        $datos = $this->procesarImagen($peticion, $datos, "logo_file", "logo_url", "brands", $marca->logo_url);

        // Actualizar la marca con los nuevos datos
        $marca->update($datos);

        return redirect()->route("admin.brands.index")
            ->with("success", "Marca actualizada exitosamente");
    }

    // Elimina una marca y todas las zapatillas asociadas a ella para mantener la integridad referencial y evitar marcas huérfanas
    public function destroyBrand($id)
    {
        // Buscar la marca o devolver 404 si no existe
        $marca = Brand::findOrFail($id);

        // Contar cuántas zapatillas tiene asociadas para mostrar en el mensaje
        $totalZapatillas = $marca->sneakers()->count();

        // Eliminar primero todas las zapatillas asociadas a la marca (integridad referencial)
        $marca->sneakers()->delete();

        // Eliminar la marca
        $marca->delete();

        // Construir mensaje informativo con el total de zapatillas eliminadas
        $mensaje = "Marca '{$marca->name}' y ";
        $mensaje .= $totalZapatillas > 0
            ? "{$totalZapatillas} zapatillas asociadas eliminadas exitosamente"
            : "sus zapatillas asociadas eliminadas exitosamente";

        return redirect()->route("admin.brands.index")->with("success", $mensaje);
    }

    // METODOS AUXILIARES

    // Valida los datos de una zapatilla y maneja la validación condicional para la imagen (URL o archivo) según si es creación o edición y si ya tiene una imagen existente o no
    private function validarZapatilla(Request $peticion, $id = null): array
    {
        // Si estamos editando, permitimos que el SKU sea el mismo que ya tiene
        $reglaSku = $id ? "unique:sneakers,sku,{$id}" : "unique:sneakers,sku";

        return $peticion->validate([
            "name" => "required|string|max:255",
            "sku" => "required|string|{$reglaSku}",
            "brand_id" => "required|exists:brands,id",
            "category" => "required|in:hombre,mujer,niño,unisex",
            "price" => "required|numeric|min:0",
            "image_url" => "required_without:image_file|nullable|url",
            "image_file" => "required_without:image_url|nullable|file|mimes:" . implode(",", self::EXTENSIONES_VALIDAS) . "|max:5120",
            "color_es" => "nullable|string",
            "color_en" => "nullable|string",
            "sizes" => "nullable|string",
            "description_es" => "nullable|string",
            "description_en" => "nullable|string",
        ], [
            "image_url.required_without" => "Debes proporcionar una URL de imagen o cargar un archivo",
            "image_file.required_without" => "Debes cargar un archivo de imagen o proporcionar una URL",
        ]);
    }

    // Valida los datos de una marca y maneja la validación condicional para el logo (URL o archivo) según si es creación o edición y si ya tiene un logo existente o no 
    private function validarMarca(Request $peticion, $id = null): array
    {
        // Si estamos editando, permitimos que el nombre sea el mismo que ya tiene
        $reglaNombre = $id ? "unique:brands,name,{$id}" : "unique:brands,name";

        return $peticion->validate([
            "name" => "required|string|{$reglaNombre}",
            "description_es" => "nullable|string",
            "description_en" => "nullable|string",
            "logo_url" => "required_without:logo_file|nullable|url",
            "logo_file" => "required_without:logo_url|nullable|file|mimes:" . implode(",", self::EXTENSIONES_VALIDAS) . "|max:5120",
        ], [
            "logo_url.required_without" => "Debes proporcionar una URL de logo o cargar un archivo",
            "logo_file.required_without" => "Debes cargar un archivo de logo o proporcionar una URL",
        ]);
    }

    // Procesa la imagen subida, valida su extensión, guarda el archivo y actualiza la URL en los datos a guardar
    private function procesarImagen(Request $peticion, array $datos, string $campoArchivo, string $campoUrl, string $carpeta, ?string $imagenAnterior = null): array
    {
        // Si no se subió ningún archivo nuevo
        if (!$peticion->hasFile($campoArchivo)) {
            // Si no hay archivo ni URL proporcionada y no hay imagen anterior, no hacemos nada
            if (!$peticion->filled($campoUrl) && $imagenAnterior === null) {
                return $datos;
            }
            // Si no se proporcionó URL, eliminamos el campo para que no se actualice con vacío
            if (!$peticion->filled($campoUrl)) {
                unset($datos[$campoUrl]);
            }
            return $datos;
        }

        // Obtener el archivo subido y su extensión
        $archivo = $peticion->file($campoArchivo);
        $extension = strtolower($archivo->getClientOriginalExtension());

        // Verificar que la extensión sea válida
        if (!in_array($extension, self::EXTENSIONES_VALIDAS)) {
            throw back()->withErrors([$campoArchivo => "Tipo de archivo no válido"])->withInput();
        }

        // Si existe una imagen anterior guardada en nuestro servidor, la eliminamos
        if ($imagenAnterior && strpos($imagenAnterior, "/{$carpeta}/") !== false) {
            $rutaAnterior = public_path($imagenAnterior);
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
        }

        // Generar nombre unico para el archivo y guardarlo
        $nombreArchivo = time() . "_" . uniqid() . "." . $extension;
        $archivo->move(public_path($carpeta), $nombreArchivo);

        // Actualizar la URL en los datos a guardar
        $datos[$campoUrl] = "/{$carpeta}/{$nombreArchivo}";

        return $datos;
    }

    // Convierte el campo de tallas de string CSV a array para almacenarlo correctamente en la base de datos
    private function procesarTallas(array $datos): array
    {
        if (!empty($datos["sizes"])) {
            // Separar por comas y eliminar espacios en blanco de cada talla
            $datos["sizes"] = array_map("trim", explode(",", $datos["sizes"]));
        }
        return $datos;
    }
}