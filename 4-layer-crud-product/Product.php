<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | Appends — brand_name is automatically included in toArray() / toJson()
    |--------------------------------------------------------------------------
    */
    protected $appends = ['brand_name'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Appended Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Appended attribute: returns brand name directly on the product.
     * Access as: $product->brand_name
     */
    public function getBrandNameAttribute(): string
    {
        return $this->brand?->name ?? 'N/A';
    }

    /**
     * Check if product is in stock.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
