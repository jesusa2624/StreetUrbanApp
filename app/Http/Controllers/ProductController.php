<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.product.index');
    }

    public function getProducts()
    {
        $products = Product::all(); // Recupera todos los productos
        return response()->json($products); // Retorna los datos en formato JSON
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
        // Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sell_price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'provider_id' => 'required|integer|exists:providers,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // Obtener el último código y generar el siguiente
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $nextCode = $lastProduct && $lastProduct->code ? str_pad((int) $lastProduct->code + 1, 8, '0', STR_PAD_LEFT) : '00000001';

        // Crear el producto
        $product = Product::create([
            'name' => $validatedData['name'],
            'code' => $nextCode, // Generar código automáticamente
            'sell_price' => $validatedData['sell_price'],
            'category_id' => $validatedData['category_id'],
            'provider_id' => $validatedData['provider_id'],
            'stock' => 0, // Inicializa el stock en 0
            'image' => $request->file('image') ? $request->file('image')->store('assets/image/products', 'public') : null,
        ]);

        // Respuesta JSON
        return response()->json(['message' => 'Producto registrado exitosamente', 'product' => $product], 201);
    }



    public function getNextBarcode()
    {
        try {
            // Obtener el último código
            $lastProduct = Product::orderBy('id', 'desc')->first();
            $nextCode = $lastProduct && $lastProduct->code ? str_pad((int) $lastProduct->code + 1, 8, '0', STR_PAD_LEFT) : '00000001';

            return response()->json(['nextCode' => $nextCode], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al calcular el próximo código de barras'], 500);
        }
    }






    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
