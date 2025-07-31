<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "leg_products";
    
    protected $fillable = [
        'name',
        'type',
        'description',
        'price_sale',
        'price_purchase',
        'stock',
        'brand',
        'image',
        'category_id',
        'presentation',
        'content',
        'expiration_date',
        'barcode',
    ];


    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'product_id');
    }

    public function isLowStock()
    {
        return $this->stock <= $this->minimum_stock;
    }

    public function isNearExpiration()
    {
        if (!$this->expiration_date) {
            return false;
        }
        return $this->expiration_date->diffInDays(now()) <= 30;
    }

        public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
