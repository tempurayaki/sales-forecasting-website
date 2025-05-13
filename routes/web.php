<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesForecastController;

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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/forecast', [SalesForecastController::class, 'index'])->name('forecast');
Route::post('/forecast', [SalesForecastController::class, 'forecast'])->name('sales.forecast');


Route::prefix('sales')->group(function () {
    //static route
    Route::get('/', [SalesController::class, "index"])->name('sales');
    Route::get('/add', [SalesController::class, "create"])->name('sales.add');
    Route::get('/upload', [SalesController::class, "upload"])->name('sales.upload');

    //dynamic route
    Route::post('store', [SalesController::class, "store"])->name('sales.store');
    Route::post('/import', [SalesController::class, 'import'])->name('sales.import');
    Route::post('detail', [SalesController::class, "detail"])->name('sales.detail');
    Route::get('/{id}', [SalesController::class, "edit"])->name('sales.edit');
    Route::put('/{id}', [SalesController::class, "update"])->name('sales.update');
    Route::delete('/{id}', [SalesController::class, "destroy"])->name('sales.delete');

    
});