<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/',function () {
    return Inertia::class::render('Home');
});
Route::get('/users', function() {
    return Inertia::class::render('Users', [
        'time' => now()->toTimeString()
    ]);
});
Route::get('/settings', fn() => Inertia::class::render('Settings'));
Route::get('/logout', function () {
});
