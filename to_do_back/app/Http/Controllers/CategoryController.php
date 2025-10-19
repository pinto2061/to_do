<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Es una excelente práctica validar los datos antes de guardarlos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        // Crea la nueva categoría con los datos validados
        $category = Category::create([
            'name' => $validatedData['name'],
            'type' => $validatedData['type'],
        ]);

        // Devuelve una respuesta JSON exitosa
        return response()->json([
            'message' => 'Category creada exitosamente.',
            'data' => $category
        ], 201); // 201 significa "Created"
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show($id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category no encontrada.'], 404);
        }
        return $category;
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, $id)
    {
        //
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category no encontrada.'], 404);
        }
        $request->validate([
            'name' => 'sometimes|required|max:255',
            'type' => 'nullable',
        ]);        
        $category->update($request->all());
        return response()->json($category, 200); // 200: OK
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category no encontrada.'], 404);
        }
        $category->delete($id);
        return response()->json(null, 204); // 204: No Content
    }
}
