<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('page.home.index');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ROUTES FOR CATEGORIES
Route::middleware('auth')->group(function () {
    Route::get('/categories/getCategories', [CategoryController::class, 'getCategories'])->name('categories.json');
    Route::resource('/categories', CategoryController::class)->names([
    'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy'
    ]);   
});

//ROUTES FOR CLIENTS
Route::middleware('auth')->group(function () {
    Route::get('/clients/getClients', [ClientController::class, 'getClients'])->name('clients.json');
    Route::resource('/clients', ClientController::class)->names([
        'index' => 'clients.index',
        'create' => 'clients.create',
        'store' => 'clients.store',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'update' => 'clients.update',
        'destroy' => 'clients.destroy'
    ]);

    // 📌 Nueva ruta para buscar DNI
    Route::get('/buscar-dni/{dni}', function ($dni) {
        $token = "apis-token-12793.ndN8GZi5D3ldyMaqDMSx8Gd9GtCjiaxz"; // ⚠️ Reemplázalo con tu token de APIS.net.pe

        $response = Http::withHeaders([
            "Authorization" => "Bearer $token",
            "Accept" => "application/json"
        ])->get("https://api.apis.net.pe/v1/dni", [
            'numero' => $dni
        ]);

        return $response->json();
    })->name('buscar.dni');
});

//ROUTES FOR PROVIDERS
Route::middleware('auth')->group(function () {
    Route::get('/providers/getProviders', [ProviderController::class, 'getProviders'])->name('providers.json');
    Route::resource('/providers', ProviderController::class)->names([
    'index' => 'providers.index',
        'create' => 'providers.create',
        'store' => 'providers.store',
        'show' => 'providers.show',
        'edit' => 'providers.edit',
        'update' => 'providers.update',
        'destroy' => 'providers.destroy'
    ]);   
    Route::get('/buscar-ruc/{ruc}', function ($ruc) {
        $token = "apis-token-12793.ndN8GZi5D3ldyMaqDMSx8Gd9GtCjiaxz"; // ⚠️ Reemplázalo con tu token de APIS.net.pe
    
        $response = Http::withHeaders([
            "Authorization" => "Bearer $token",
            "Accept" => "application/json"
        ])->get("https://api.apis.net.pe/v1/ruc", [
            'numero' => $ruc
        ]);
    
        return $response->json();
    })->name('buscar.ruc');
});

//ROUTES FOR PRODUCTS
Route::middleware('auth')->group(function () {
    Route::get('/products/getProducts', [ProductController::class, 'getProducts'])->name('products.json');
    Route::get('/products/next-barcode', [ProductController::class, 'getNextBarcode'])->name('products.nextBarcode');

    // Nueva ruta para obtener las tallas de un producto
    Route::get('/products/{productId}/sizes', [ProductController::class, 'getSizes']);
    
    Route::get('/products/top-selling', [ProductController::class, 'getTopSellingProducts']);

    Route::resource('/products', ProductController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'store' => 'products.store',
        'show' => 'products.show',
        'edit' => 'products.edit',
        'update' => 'products.update',
        'destroy' => 'products.destroy'
    ]);
});

//ROUTES FOR PURCHASES
Route::middleware('auth')->group(function () {
    Route::get('/purchases/getPurchases', [PurchaseController::class, 'getPurchases'])->name('purchases.json');
    Route::get('/purchases/{id}/details', [PurchaseController::class, 'getPurchaseDetails'])->name('purchases.details');
    Route::get('sizes/getSizes', [PurchaseController::class, 'getSizes'])->name('sizes.json');
    Route::post('/purchases/change-status/{id}', [PurchaseController::class, 'changeStatus'])->name('purchases.change-status');

    Route::get('/purchases/current-month', [PurchaseController::class, 'getCurrentMonthPurchases'])->name('purchases.currentMonth');
    Route::get('/purchases/monthly', [PurchaseController::class, 'getMonthlyPurchases']);

    Route::resource('/purchases', PurchaseController::class)->names([
        'index' => 'purchases.index',
        'create' => 'purchases.create',
        'store' => 'purchases.store',
        'show' => 'purchases.show',
        'edit' => 'purchases.edit',
        'update' => 'purchases.update',
        'destroy' => 'purchases.destroy'
    ]);
});

//ROUTES FOR SALES
Route::middleware('auth')->group(function () {
    Route::get('/sales/getSales', [App\Http\Controllers\SaleController::class, 'getSales'])->name('sales.json');
    Route::get('/products/{id}/details', [ProductController::class, 'getProductDetails'])->name('products.details');

    Route::get('/sales/{id}/details', [App\Http\Controllers\SaleController::class, 'getSaleDetails'])->name('sales.details');
    Route::post('/sales/change-status/{id}', [App\Http\Controllers\SaleController::class, 'changeStatus'])->name('sales.change-status');

    Route::get('/sales/current-month', [SaleController::class, 'getCurrentMonthSales']);
    Route::get('/sales/monthly', [SaleController::class, 'getMonthlySales']);

    Route::get('/sales/daily', [SaleController::class, 'getDailySales']);


    Route::resource('/sales', App\Http\Controllers\SaleController::class)->names([
        'index' => 'sales.index',
        'create' => 'sales.create',
        'store' => 'sales.store',
        'show' => 'sales.show',
        'edit' => 'sales.edit',
        'update' => 'sales.update',
        'destroy' => 'sales.destroy'
    ]);
});








require __DIR__.'/auth.php';
