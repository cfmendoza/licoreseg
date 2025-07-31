<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = "leg_sale_details";
    protected $fillable = ['product_id','quantity', 'unit_price', 'sale_id', 'subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');  
    }

    
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id'); 
    }
}
