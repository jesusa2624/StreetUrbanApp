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
                return [
                    'id' => $sale->id,
                    'client_name' => $sale->client->name,
                    'status' => $sale->status,
                    'total' => number_format($sale->total, 2), // Usamos el total guardado en la tabla sales
                    'products' => $sale->saleDetails->map(function ($detail) {
                        return [
                            'product_name' => $detail->product->name,
                            'quantity' => $detail->quantity,
                            'price' => $detail->price,
                            'subtotal' => number_format($detail->price * $detail->quantity, 2),
                            'size' => $detail->size ? $detail->size->name : 'N/A', // Muestra la talla
                        ];
                    }),
                ];
            });

        return response()->json($sales);
    }

    public function getSaleDetails($id)
    {
        try {
            // Buscar la venta con las relaciones necesarias, incluyendo la relación con las tallas de cada producto
            $sale = Sale::with(['client', 'saleDetails.product.sizes', 'saleDetails.size']) // Incluir la relación 'sizes' de productos
                ->find($id);

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
                        'price' => (float) $detail->price,
                        'subtotal' => (float) ($detail->price * $detail->quantity),
                        'size' => $detail->size ? $detail->size->name : 'N/A', // Muestra la talla del SaleDetail
                        'product_sizes' => $detail->product->sizes->map(function ($size) { // Aquí obtenemos las tallas del producto
                            return [
                                'id' => $size->id,
                                'name' => $size->name
                            ];
                        }),
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
            $sale = Sale::with('saleDetails.product')->find($id);

            if (!$sale) {
                return response()->json(['message' => 'Venta no encontrada.'], 404);
            }

            $newStatus = $sale->status === 'VALID' ? 'CANCELED' : 'VALID';

            // Modificar stock solo si la venta pasa a CANCELADO
            if ($newStatus === 'CANCELED') {
                foreach ($sale->saleDetails as $detail) {
                    if ($detail->product) {
                        $detail->product->stock += $detail->quantity;
                        $detail->product->save();
                    } else {
                        Log::warning("Producto no encontrado en detalle de venta ID {$detail->id}");
                    }
                }
            } elseif ($newStatus === 'VALID') {
                foreach ($sale->saleDetails as $detail) {
                    if ($detail->product) {
                        if ($detail->product->stock >= $detail->quantity) {
                            $detail->product->stock -= $detail->quantity;
                            $detail->product->save();
                        } else {
                            return response()->json(['message' => 'Stock insuficiente para revalidar la venta.'], 400);
                        }
                    }
                }
            }

            $sale->update(['status' => $newStatus]);

            return response()->json(['message' => 'Estado cambiado con éxito.', 'status' => $newStatus]);
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado de la venta:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }

    public function getCurrentMonthSales()
    {
        $currentMonth = now()->format('Y-m');

        $sales = Sale::select(
            DB::raw('SUM(total) as total_sales'),
            DB::raw('COUNT(id) as total_transactions')
        )
            ->whereRaw('DATE_FORMAT(sale_date, "%Y-%m") = ?', [$currentMonth])
            ->where('status', '!=', 'CANCELED') // Excluir ventas canceladas
            ->first();

        return response()->json($sales);
    }

    public function getMonthlySales()
    {
        try {
            $sales = Sale::select(
                DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month'),
                DB::raw('SUM(total) as total_sales')
            )
                ->where('status', '!=', 'CANCELED') // Excluir ventas canceladas
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            return response()->json($sales);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener ventas', 'message' => $e->getMessage()], 500);
        }
    }

    public function getDailySales()
    {
        $currentMonth = now()->format('Y-m');

        $sales = Sale::select(
            DB::raw('DATE_FORMAT(sale_date, "%d-%m-%Y") as date'), // Formato DD-MM-YYYY
            DB::raw('SUM(total) as total_sales')
        )
            ->whereRaw('DATE_FORMAT(sale_date, "%Y-%m") = ?', [$currentMonth])
            ->where('status', '!=', 'CANCELED') // Excluir ventas canceladas
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos del request
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'tax' => 'required|numeric|min:0',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.price' => 'required|numeric|min:0',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.discount' => 'required|numeric|min:0',
                'products.*.size_id' => 'required|exists:sizes,id',  // Asegúrate de validar el size_id
            ]);

            DB::beginTransaction();

            // Crear la venta
            $sale = Sale::create([
                'client_id' => $validated['client_id'],
                'user_id' => Auth::id(),
                'sale_date' => now(),
                'tax' => $validated['tax'],
                'total' => 0, // Inicializado como 0, se actualizará después
                'status' => 'VALID',
            ]);

            $total = 0;

            // Procesar los productos
            foreach ($validated['products'] as $productData) {
                $product = Product::findOrFail($productData['product_id']);

                // Nuevo cálculo del subtotal restando el descuento como monto fijo
                $subtotal = ($productData['price'] * $productData['quantity']) - $productData['discount'];

                // Asegurar que el subtotal no sea negativo
                $subtotal = max($subtotal, 0);

                // Crear el detalle de la venta con el tamaño
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'discount' => $productData['discount'], // Se almacena el monto fijo del descuento
                    'size_id' => $productData['size_id'], // Guardar el size_id
                ]);

                // Reducir el stock del producto
                $product->decrement('stock', $productData['quantity']);
                $total += $subtotal;
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
