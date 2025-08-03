<?php

namespace Modules\Inventario\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Mostrar lista de categorías (opcional, para administración)
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Mostrar formulario de creación (opcional)
    public function create()
    {
        return view('categories.create');
    }

    // Guardar nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:leg_categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente.',
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la categoría.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // Si necesitas un método para cargar desde AJAX (por ejemplo, para un select2 dinámico)
    public function getAll()
    {
        return response()->json(Category::select('id', 'name')->get());
    }
}
