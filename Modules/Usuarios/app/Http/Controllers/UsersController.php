<?php

namespace Modules\Usuarios\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); 
        $roles = Role::all(); 
        $permisos = Permission::all();
        return view('usuarios::index', compact('users', 'roles', 'permisos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $roles = Role::all();
    return view('usuarios::create', compact('roles'));
}

public function store(Request $request)
{
    $user = User::create($request->only('name', 'email', 'password'));
    $user->syncRoles($request->roles);
    return redirect()->route('usuarios.index')->with('success', 'Usuario creado.');
}

public function edit(User $usuario)
{
    $roles = Role::all();
    return view('usuarios::edit', [
        'user' => $usuario,  
        'roles' => $roles
    ]);
}


public function update(Request $request, User $user)
{
    $user->update($request->only('name', 'email'));
    if ($request->filled('password')) {
        $user->update(['password' => bcrypt($request->password)]);
    }
    $user->syncRoles($request->roles);
    return redirect()->route('usuarios::index')->with('success', 'Usuario actualizado.');
}
}
