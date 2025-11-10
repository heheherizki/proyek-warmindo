<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_name',
        'total_amount',
        'payment_method',
        'status',
        'payment_status',
        'qr_code_url',
    ];

    /**
     * Sebuah Order memiliki banyak OrderItem
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}