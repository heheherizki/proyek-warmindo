<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'total_amount',
        'payment_method',
        'status',
    ];

        // Sebuah Order memiliki banyak OrderItem
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
