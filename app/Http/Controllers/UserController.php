<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
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
                        'delete' => auth()->user()->can('delete', $user),
                    ]
                ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => auth()->user()->can('create', User::class)
            ]
        ]);
    }

    public function create(){
        return Inertia::render('Users/Create');
    }

    public function store(Request $request){
        $validated = Request::validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create($validated);

        return redirect('/users');
    }

    public function edit(User $user){
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'can' => [
                    'update' => auth()->user()->can('update', $user),
                ],
            ],
        ]);
    }

    public function update(Request $request, User $user){
        $validated = Request::validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update($validated);
        return redirect('/users');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect('/users');
    }
}
