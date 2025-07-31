<?php
namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name'];
    // Puedes agregar funcionalidades extra aquí también
}
