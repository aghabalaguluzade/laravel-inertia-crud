<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use App\Models\User;
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

    Route::get('/users', function() {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->when(Request::input('search'), fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
                ->whereNot('id',auth()->user()->id)
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'can' => [
                        'update' => auth()->user()->can('update', $user),
                    ]
                ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => auth()->user()->can('create', User::class)
            ]
        ]);
    });

    Route::get('/users/create', function() {
        return Inertia::render('Users/Create');
    })->can('create','App\Models\User');

    Route::post('/users', function() {
        $validated = Request::validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create($validated);

        return redirect('/users');
    });

    Route::get('/settings', fn() => Inertia::render('Settings'));
    Route::get('/logout', function () {});

});
