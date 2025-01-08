<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('page.home.index');
})->middleware(['auth', 'verified'])->name('index');

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
});







require __DIR__.'/auth.php';
