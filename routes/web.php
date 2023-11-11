<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\CashierController;

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

Route::get('/', [CashierController::class, 'index'])->name('cashier.index');

Route::get('/cashier/getTable', [CashierController::class, 'getTables']);
Route::post('/cashier/order', [CashierController::class, 'order']);
Route::get('/cashier/getOrderDetailsByTable/{table_id}', [CashierController::class, 'getOrderDetailsByTable']);
Route::post('/cashier/confirmOrderStatus', [CashierController::class, 'confirmOrderStatus']);
Route::post('/cashier/deleteOrderDetail', [CashierController::class, 'deleteOrderDetail']);
Route::post('/cashier/payment', [CashierController::class, 'payment']);

Route::prefix('admin')->group(function() {
   Route::resource('tables', \App\Http\Controllers\Admin\TableController::class);
   Route::resource('dishes', \App\Http\Controllers\Admin\DishController::class);
   Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
   Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
});

//Route::resource('tables', \App\Http\Controllers\TableController::class);
Route::post('/cashier/ordertable', [CashierController::class, 'orderTable'])->name('cashier.ordertable');
Route::post('/cashier/ordertable/category', [CashierController::class, 'getCategoryById']);
Route::post('/cashier/ordertable/editQuantity', [CashierController::class,'editQuantity']);
