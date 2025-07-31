<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = "leg_sales";
    protected $fillable = [
        'customer_id',
        'user_id',
        'date',
        'status',
        'total',
    ];




    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id'); 
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class , 'customer_id');
    }

    
}

