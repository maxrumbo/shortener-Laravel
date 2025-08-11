
<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ShortLinkController;

Route::get('/', function () {
    return view('welcome');
});

// API untuk membuat shortlink
Route::post('/shorten', [ShortLinkController::class, 'store']);
// API untuk cek ketersediaan alias (opsional)
Route::get('/check-alias', [ShortLinkController::class, 'checkAlias']);
// Redirect dari alias ke original_url
Route::get('/{alias}', [ShortLinkController::class, 'show'])->where('alias', '[A-Za-z0-9]+');
