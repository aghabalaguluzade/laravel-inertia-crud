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

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/users/create', [UserController::class, 'create'])->can('create','App\Models\User');

    Route::post('/users', [UserController::class, 'store'])->can('create','App\Models\User');;

    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->can('update','App\Models\User');

    Route::put('/users/update/{user}', [UserController::class, 'update'])->name('update');

    Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->can('delete','App\Models\User');;

    Route::get('/logout', function () {});

});
