<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "leg_customers";
    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
