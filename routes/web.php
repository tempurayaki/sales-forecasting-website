<?php

use App\Http\Controllers\Admin\UserManagementController;
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

// Route untuk halaman utama - cek login dulu
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect()->route('login');
});

Auth::routes();

// Route untuk halaman utama - redirect ke login jika belum login
Route::get('/', function () {
    return Auth::check() ? redirect('/home') : redirect()->route('login');
});

Auth::routes();

// Semua route yang butuh login
Route::middleware(['auth'])->group(function () {
    // Routes yang dapat diakses oleh admin dan user (Dashboard dan Forecasting)
    Route::middleware(['role:admin,user'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        // Route untuk halaman forecasting
        Route::get('/forecasting', [SalesForecastController::class, 'index'])->name('forecasting');
        Route::post('/forecasting/get-forecast', [SalesForecastController::class, 'getForecast'])->name('forecasting.get-forecast');
        Route::get('/forecasting/export/excel', [SalesForecastController::class, 'exportExcel'])->name('forecast.export.excel');
        Route::get('/forecasting/export/csv', [SalesForecastController::class, 'exportCsv'])->name('forecast.export.csv');
        Route::get('/forecasting/generate-report', [SalesForecastController::class, 'generateForecastReport'])->name('forecast.generate-report');
    });

    // Routes yang hanya dapat diakses oleh admin
    Route::middleware(['role:admin'])->group(function () {
        // Sales routes - hanya admin
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

        // Admin routes - hanya admin
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', UserManagementController::class);
            Route::put('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        });
    });
});