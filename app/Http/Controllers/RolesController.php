<?php

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller {
    public function index() {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }
    
}