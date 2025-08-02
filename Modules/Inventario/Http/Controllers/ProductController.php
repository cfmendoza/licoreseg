<?php

namespace Modules\Inventario\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->get();
        return view('inventario::index', compact('products'));
    }

    // Mostrar formulario de creación
public function create()
{
    $categories = Category::all();
    return view('inventario::create', compact('categories'));
}

    // Guardar nuevo producto
public function store(Request $request)
{
    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'type'            => 'nullable|string|max:255',
        'description'     => 'nullable|string|max:500',
        'price_purchase'  => 'required|numeric|min:0', // nombre correcto
        'price_sale'      => 'required|numeric|min:0', // nombre correcto
        'stock'           => 'required|integer|min:0',
        'brand'           => 'nullable|string|max:255',
        'category_id'     => 'required|exists:leg_categories,id',
        'presentation'    => 'nullable|string|max:255',
        'content_ml'      => 'nullable|integer|min:0', // nombre correcto
        'expiration_date' => 'nullable|date',
        'barcode'         => 'nullable|string|max:100',
        'image'           => 'nullable|image|max:2048', // opcional si vas a subir imágenes
    ]);

    // Opcional: manejar subida de imagen si se proporciona
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
}


    // Mostrar formulario de edición
public function edit(Product $product)
{
    $categories = Category::orderBy('name')->get();
    return view('inventario::edit', compact('product', 'categories'));
}



public function update(Request $request, Product $product)
{

    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'type'            => 'nullable|string|max:255',
        'description'     => 'nullable|string|max:500',
        'price_purchase'  => 'required|numeric|min:0',
        'price_sale'      => 'required|numeric|min:0',
        'stock'           => 'required|integer|min:0',
        'brand'           => 'nullable|string|max:255',
        'category_id'     => 'required|exists:leg_categories,id',
        'presentation'    => 'nullable|string|max:255',
        'content'      => 'nullable|integer|min:0',
        'expiration_date' => 'nullable|date',
        'barcode'         => 'nullable|string|max:100',
        'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // máximo 2MB
    ]);


    //dd($validated);

    // Manejo de imagen si se envió una nueva
    if ($request->hasFile('image')) {
        // Elimina imagen anterior si existe
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Guarda nueva imagen
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    //dd($validated);
    $product->update($validated);

    return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
}



    // Eliminar producto
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
