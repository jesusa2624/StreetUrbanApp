<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.category.index');
    }

    public function getCategories()
    {
        $categories = Category::all(); // Recupera todas las categorías
        return response()->json($categories); // Retorna los datos en formato JSON
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Crear una nueva categoría
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];
        $category->save(); // Guardar en la base de datos

        // Retornar una respuesta
        return response()->json(['message' => 'Categoría registrada exitosamente'], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valida los datos que vienen del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Encuentra la categoría por ID
        $category = Category::find($id);

        // Si no encuentra la categoría, muestra un error
        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Actualiza los valores de la categoría con los datos validados
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'] ?? $category->description; // Mantiene la descripción si no se actualiza

        // Guarda los cambios
        $category->save();

        // Devuelve una respuesta con la categoría actualizada
        return response()->json($category);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Elimina la categoría
        $category->delete();

        return response()->json(['message' => 'Categoría eliminada con éxito'], 200);
    }
}
