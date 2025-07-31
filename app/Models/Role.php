<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name'];
    // Aquí puedes añadir métodos o relaciones adicionales si lo deseas
}
