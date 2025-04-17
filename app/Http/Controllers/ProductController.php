<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        $products = Product::with(['category', 'purchaseDetails.size']) // Asegúrate de cargar la relación 'category'
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'code' => $product->code,
                    'stock' => $product->stock,
                    'sell_price' => $product->sell_price,
                    'status' => $product->status,
                    'category' => $product->category ?: 'Sin Categoría', // Asegúrate de que la categoría esté presente
                    'image' => $product->image,
                    'sizes' => $product->purchaseDetails->map(function ($detail) {
                        return [
                            'id' => $detail->size->id,
                            'name' => $detail->size->name,
                            'stock' => $detail->quantity, // Usar quantity como stock por talla
                        ];
                    })->unique('id')->values(),
                ];
            });

        return response()->json($products);
    }



    public function getProductDetails($id)
    {
        // Buscar el producto por su ID
        $product = Product::find($id);

        // Si no se encuentra, devolver un error 404
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Devolver los detalles del producto
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'stock' => $product->stock,
            'sell_price' => $product->sell_price,
        ]);
    }

    public function getSizes($productId)
    {
        $product = Product::findOrFail($productId);
        $sizes = $product->sizes;  // Asumiendo que tienes una relación `sizes()` en el modelo Product
        return response()->json($sizes);
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
        // Validar los datos enviados por el formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sell_price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'provider_id' => 'required|integer|exists:providers,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:2048', // Extensiones válidas
        ]);

        // Generar el próximo código de barras
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $nextCode = $lastProduct && $lastProduct->code
            ? str_pad((int) $lastProduct->code + 1, 8, '0', STR_PAD_LEFT)
            : '00000001';

        // Manejar la carga de la imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = now()->format('d_m_Y_His') . '_' . $image->getClientOriginalName(); // Evitar conflictos de nombres

            // Ruta directa en `public`
            $destinationPath = public_path('assets/image/products');
            $image->move($destinationPath, $imageName); // Mover el archivo a la carpeta

            $imagePath = 'assets/image/products/' . $imageName; // Ruta para guardar en la BD
        }

        // Crear el producto en la base de datos
        $product = Product::create([
            'name' => $validatedData['name'],
            'code' => $nextCode, // Asignar el código generado automáticamente
            'sell_price' => $validatedData['sell_price'],
            'category_id' => $validatedData['category_id'],
            'provider_id' => $validatedData['provider_id'],
            'stock' => 0, // El stock se inicializa en 0
            'image' => $imagePath, // Ruta de la imagen si existe
        ]);

        // Devolver una respuesta JSON con el producto creado
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

    public function getTopSellingProducts()
    {
        $topProducts = DB::table('sale_details')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id') // Unir con la tabla de ventas
            ->where('sales.status', '!=', 'CANCELED') // Excluir ventas canceladas
            ->select(
                'products.id',
                'products.image',
                'products.name',
                'products.code',
                'products.stock',
                DB::raw('SUM(sale_details.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.image', 'products.name', 'products.code', 'products.stock')
            ->orderByDesc('total_sold')
            ->limit(10) // Top 10 productos más vendidos
            ->get();

        return response()->json($topProducts);
    }

    public function getSizesByProduct($id)
    {
        $product = Product::with(['purchaseDetails.size'])->findOrFail($id);

        $sizes = $product->purchaseDetails
            ->groupBy('size_id')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'size_id' => $first->size_id,
                    'size_name' => $first->size->name,
                    'stock' => $items->sum('quantity'),
                    'price' => $first->product->sell_price,
                    'code' => $first->product->code,
                ];
            })->values();

        return response()->json($sizes);
    }






    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Busca el producto por ID
        $product = Product::find($id);

        // Si el producto no se encuentra, devuelve un error 404
        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Retorna el producto encontrado en formato JSON
        return response()->json($product);
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
    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sell_price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'provider_id' => 'required|integer|exists:providers,id',
            'code' => 'required|string|max:255|unique:products,code,' . $id, // Código único excepto para este producto
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:2048', // Validar tipos de imagen
        ]);

        // Encontrar el producto existente
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Manejar la carga de la imagen
        $imagePath = $product->image; // Mantener la ruta existente si no se actualiza
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($imagePath && \File::exists(public_path($imagePath))) {
                \File::delete(public_path($imagePath));
            }

            // Procesar la nueva imagen
            $image = $request->file('image');
            $imageName = now()->format('d_m_Y_His') . '_' . $image->getClientOriginalName(); // Evitar conflictos de nombres

            // Guardar la nueva imagen en la carpeta deseada
            $destinationPath = public_path('assets/image/products');
            $image->move($destinationPath, $imageName);

            // Actualizar la ruta de la nueva imagen
            $imagePath = 'assets/image/products/' . $imageName;
        }

        // Actualizar los valores del producto
        $product->update([
            'name' => $validatedData['name'],
            'code' => $validatedData['code'],
            'sell_price' => $validatedData['sell_price'],
            'category_id' => $validatedData['category_id'],
            'provider_id' => $validatedData['provider_id'],
            'image' => $imagePath,
        ]);

        // Devolver una respuesta JSON con el producto actualizado
        return response()->json(['message' => 'Producto actualizado exitosamente', 'product' => $product], 200);
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Elimina los detalles de venta relacionados si existen
        $product->saleDetails()->delete();

        // Elimina la imagen si existe
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente']);
    }
}
