<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Models\Inventory;
use App\Models\Purchase;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/inventory', [InventoryController::class, 'index'])->middleware(['auth', 'verified'])->name('inventory');
Route::middleware('auth')->group(function () {
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/show', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/show/{id}', [InventoryController::class, 'showById'])->name('inventory.showbyid');
    Route::patch('/inventory', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/cetak/{id}', [SalesController::class, 'cetak'])->name('sales.cetak');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::patch('/sales', [SalesController::class, 'update'])->name('sales.update');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/cetak/{id}', [PurchaseController::class, 'cetak'])->name('purchase.cetak');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::patch('/purchase', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::delete('/purchase/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
