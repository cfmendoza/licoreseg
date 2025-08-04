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
        $permissions = Permission::all();
        return view('usuarios::index', compact('users', 'roles', 'permissions'));

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

public function update(Request $request, $id)
{
    $data = $request->only('name', 'email');

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user = User::findOrFail($id); // ← Aquí estaba el problema
    $user->update($data);

    if ($request->has('roles')) {
        $user->syncRoles($request->roles);
    }

    return response()->json([
        'success' => true,
        'message' => 'Usuario actualizado'
    ]);
}


public function destroy($id)
{
    $user = User::findOrFail($id);

    // Evita que se elimine a sí mismo
    if (auth()->id() == $user->id) {
        return response()->json([
            'success' => false,
            'message' => 'No puedes eliminar tu propio usuario.'
        ], 403);
    }

    // Elimina el usuario
    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'Usuario eliminado correctamente.'
    ]);
}


}
