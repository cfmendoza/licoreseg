<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:roles,name',
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $role = Role::create(['name' => $request->name]);

    if ($request->filled('permissions')) {
        $role->syncPermissions($request->permissions);
    }

    return back()->with('success', 'Rol creado exitosamente.');
}


    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return back()->with('success', 'Rol actualizado');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Rol eliminado');
    }
}
