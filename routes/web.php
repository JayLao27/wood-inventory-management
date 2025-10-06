<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Auth.Login');
});
Route::get('/inventory', function () {
    return view('Systems\inventory');
})->middleware(['auth', 'verified'])->name('inventory');



require __DIR__.'/auth.php';
