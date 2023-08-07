<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use App\Models\User;

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
    return Inertia::render('Home');
});

Route::get('/users', function() {
    return Inertia::render('Users/Index', [
        'users' => User::query()
            ->when(Request::input('search'), fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
            ]),
        'filters' => Request::only(['search'])
    ]);
});

Route::get('/users/create', function() {
    return Inertia::render('Users/Create');
});

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
Route::get('/logout', function () {
    // Rest of the code...
});
