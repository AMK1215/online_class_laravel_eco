<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'variant_name', 
        'variant_value', 
        'price_adjustment', 
        'quantity', 
        'sku'
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
