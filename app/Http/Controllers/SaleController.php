<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.sale.index');
    }


    public function getSales()
    {
        $sales = Sale::with(['client', 'saleDetails.product'])
            ->get()
            ->map(function ($sale) {
                $total = $sale->saleDetails->sum(function ($detail) {
                    return $detail->price * $detail->quantity; // Calcula el subtotal
                });

                return [
                    'id' => $sale->id,
                    'client_name' => $sale->client->name,
                    'status' => $sale->status,
                    'total' => $total, // Asegúrate de devolver un número
                    'products' => $sale->saleDetails->map(function ($detail) {
                        return [
                            'product_name' => $detail->product->name,
                            'quantity' => $detail->quantity,
                            'price' => $detail->price,
                            'subtotal' => $detail->price * $detail->quantity,
                        ];
                    }),
                ];
            });

        return response()->json($sales);
    }

    public function getSaleDetails($id)
    {
        try {
            // Buscar la venta con las relaciones necesarias
            $sale = Sale::with(['client', 'saleDetails.product'])->find($id);

            if (!$sale) {
                return response()->json(['message' => 'Venta no encontrada'], 404);
            }

            // Formatear los datos de la venta
            return response()->json([
                'id' => $sale->id,
                'client_name' => $sale->client->name,
                'sale_date' => $sale->sale_date,
                'status' => $sale->status,
                'tax' => (float) $sale->tax,
                'total' => (float) $sale->total,
                'products' => $sale->saleDetails->map(function ($detail) {
                    return [
                        'product_name' => $detail->product->name,
                        'quantity' => $detail->quantity,
                        'price' => (float) $detail->price, // Asegúrate de que sea un número
                        'subtotal' => (float) ($detail->price * $detail->quantity), // Cálculo como número
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener los detalles de la venta:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function changeStatus($id)
    {
        try {
            $sale = Sale::find($id);

            if (!$sale) {
                return response()->json(['message' => 'Venta no encontrada.'], 404);
            }

            // Cambiar el estado
            $newStatus = $sale->status === 'VALID' ? 'CANCELED' : 'VALID';
            $sale->update(['status' => $newStatus]);

            return response()->json(['message' => 'Estado cambiado con éxito.', 'status' => $newStatus]);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado de la venta:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar datos del request
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'tax' => 'required|numeric|min:0',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.price' => 'required|numeric|min:0',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.discount' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            // Crear la venta
            $sale = Sale::create([
                'client_id' => $validated['client_id'],
                'user_id' => Auth::id(),
                'sale_date' => now(),
                'tax' => $validated['tax'],
                'total' => 0, // Inicializado como 0, se actualizará después
                'status' => 'VALID', // Valor predeterminado según el ENUM
            ]);

            $total = 0;

            // Procesar los productos
            foreach ($validated['products'] as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                $subtotal = $productData['price'] * $productData['quantity'];
                $subtotalWithDiscount = $subtotal - ($subtotal * $productData['discount'] / 100);

                // Crear el detalle de la venta
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'discount' => $productData['discount'],
                ]);

                // Reducir el stock del producto
                $product->decrement('stock', $productData['quantity']);
                $total += $subtotalWithDiscount;
            }

            // Calcular el total con impuesto
            $totalWithTax = $total + ($total * $validated['tax'] / 100);
            $sale->update(['total' => $totalWithTax]);

            DB::commit();

            return response()->json(['message' => 'Venta registrada exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar la venta', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
