<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;



class PermissionsController extends Controller {
    public function index() {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }
}
