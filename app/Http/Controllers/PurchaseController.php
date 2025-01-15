<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Mostrar la página principal de compras.
     */
    public function index()
    {
        return view('page.purchase.index');
    }

    /**
     * Recuperar todas las compras en formato JSON.
     */
    public function getProviders()
    {
        $providers = Provider::all(); // Obtener todos los proveedores
        return response()->json($providers);
    }

    public function getProducts()
    {
        $products = Product::all(); // Obtener todos los productos
        return response()->json($products);
    }



    /**
     * Almacenar una nueva compra.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos:', $request->all());

            $validated = $request->validate([
                'provider_id' => 'required|exists:providers,id',
                'tax' => 'required|numeric|min:0',
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.price' => 'required|numeric|min:0',
                'products.*.quantity' => 'required|integer|min:1',
            ]);
            Log::info('Datos validados correctamente.');

            DB::beginTransaction();

            $purchase = Purchase::create([
                'provider_id' => $validated['provider_id'],
                'user_id' => Auth::id(),
                'purchase_date' => now(),
                'tax' => $validated['tax'],
                'total' => 0,
                'status' => 'VALID',
            ]);
            Log::info('Compra creada:', $purchase->toArray());

            $total = 0;

            foreach ($validated['products'] as $productData) {
                Log::info('Procesando producto:', $productData);

                $product = Product::find($productData['product_id']);
                if (!$product) {
                    throw new \Exception("Producto no encontrado con ID: {$productData['product_id']}");
                }

                $subtotal = $productData['price'] * $productData['quantity'];

                PurchaseDetails::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                ]);

                $product->increment('stock', $productData['quantity']);
                $total += $subtotal;
            }

            $totalWithTax = $total + ($total * $validated['tax'] / 100);
            $purchase->update(['total' => $totalWithTax]);
            Log::info('Total actualizado correctamente:', ['total' => $totalWithTax]);

            DB::commit();

            return response()->json(['message' => 'Compra registrada exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar la compra:', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Error al registrar la compra', 'error' => $e->getMessage()], 500);

        }
    }




    /**
     * Mostrar una compra específica.
     */
    public function show($id)
    {
        $purchase = Purchase::with('details.product')->find($id);

        if (!$purchase) {
            return response()->json(['error' => 'Compra no encontrada'], 404);
        }

        return response()->json($purchase);
    }

    /**
     * Actualizar una compra.
     */
    public function update(Request $request, $id)
    {
        // Validar datos de la solicitud
        $validatedData = $request->validate([
            'tax' => 'required|numeric|min:0',
            'status' => 'required|string|in:VALID,CANCELLED',
        ]);

        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json(['error' => 'Compra no encontrada'], 404);
        }

        $purchase->update($validatedData);

        return response()->json(['message' => 'Compra actualizada con éxito']);
    }

    /**
     * Eliminar una compra.
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json(['error' => 'Compra no encontrada'], 404);
        }

        // Revertir el stock de los productos asociados
        foreach ($purchase->details as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                $product->decrement('stock', $detail->quantity);
            }
        }

        $purchase->delete();

        return response()->json(['message' => 'Compra eliminada con éxito'], 200);
    }
}
