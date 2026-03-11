<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable Fields
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'user_id',
        'order_status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */
    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * An order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An order has many order details (products).
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get total quantity of all products in this order.
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->orderDetails->sum('product_quantity');
    }

    /**
     * Get total number of products in this order.
     */
    public function getTotalProductsAttribute(): int
    {
        return $this->orderDetails->count();
    }
}
