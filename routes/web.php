<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/',function () {
        return Inertia::render('Home');
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/create', [UserController::class, 'create'])->can('create','App\Models\User');

    Route::post('/users', [UserController::class, 'store'])->can('create','App\Models\User');;

    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->can('update','App\Models\User');

    Route::put('/users/update/{id}', [UserController::class, 'update'])->can('update','App\Models\User')->can('delete','App\Models\User');;

    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->can('delete','App\Models\User');;

    Route::get('/settings', fn() => Inertia::render('Settings'));
    Route::get('/logout', function () {});

});
