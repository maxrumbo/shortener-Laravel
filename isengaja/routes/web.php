use App\Http\Controllers\PortfolioController;

// Route untuk user (frontend)
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');

// Route untuk admin (backend)
Route::get('admin/portfolio', [PortfolioController::class, 'adminIndex'])->name('admin.portfolio.index');
Route::resource('admin/portfolio', PortfolioController::class)->except(['index', 'show']);
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
